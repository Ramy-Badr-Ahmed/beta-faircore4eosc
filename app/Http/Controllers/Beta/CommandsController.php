<?php

namespace App\Http\Controllers\Beta;

use App\Events\ProlongedArchival;
use App\Http\Controllers\Controller;
use App\Models\SoftwareHeritageRequest;
use App\Modules\SwhApi\Archival\Archive;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use Throwable;
use TypeError;

class CommandsController extends Controller
{
    public static bool $echoFlag = true;

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param string $infoLog
     * @return void
     */

    public static function addLogs(string $infoLog): void
    {
        Log::channel('cronDBLogs')->info($infoLog);

        if(self::$echoFlag){
            echo "\n".$infoLog."\n";
        }
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param array|null $url
     * @return void
     * @throws Exception
     */

    public static function requestsCron(?array $url): void
    {
        try {
            if(DB::connection()->getPDO())
            {
                $connections = DB::scalar('select count(ID) from information_schema.processlist where db = ?', [DB::connection()->getDatabaseName()]);
                self::addLogs("Current Connections to DB: ".$connections);
            }
        } catch(PDOException|QueryException $e) {
            is_a($e, QueryException::class)
                ? self::addLogs("Check query --> ".$e->getMessage())
                : self::addLogs("Error connecting to database --> ".$e->getMessage());
            return;
        }

        try{
            $openArchivalRequests = is_array($url)
                ? SoftwareHeritageRequest::whereIn('originUrl', $url)->whereNull('swhIdList')-> get()
                : SoftwareHeritageRequest::whereNull('swhIdList')->where('isValid', '!=', false)->get();

        }catch (QueryException $e){
            $e->getCode() == '2002'
                ? self::addLogs("QueryException: Possible overload/Offline DB --> ".$e->getMessage())
                : self::addLogs("QueryException: ".$e->getMessage());
            return;
        };

        if(count($openArchivalRequests->all()) > 0){    // non-archived

            self::addLogs("Looping SWH Requests...");

            foreach ($openArchivalRequests as $openArchivalRequest) {

                self::addLogs("Visiting: $openArchivalRequest->originUrl");

                if(self::isProlongedArchival($openArchivalRequest)) continue;

                $archivalRequest = new Archive($openArchivalRequest->originUrl, $openArchivalRequest->visitType, isVerbose: true );

                $updatedStatus = $archivalRequest->getArchivalStatus($openArchivalRequest->saveRequestId ?? $openArchivalRequest->saveRequestDate);

                if($updatedStatus instanceof Throwable){
                    switch (true){
                        case is_a($updatedStatus, TypeError::class):
                            self::addLogs($openArchivalRequest->originUrl." --> Throwable: non-generated swhid");
                            break;
                        case is_a($updatedStatus, Exception::class):

                            if(is_a($updatedStatus, ConnectionException::class)){
                                self::addLogs($openArchivalRequest->originUrl." --> ConnectionException thrown: {$updatedStatus->getMessage()}");
                                $openArchivalRequest->hasConnectionError = true;
                            }
                            else{
                                self::addLogs($openArchivalRequest->originUrl." --> Exception thrown: {$updatedStatus->getMessage()}");

                                if($updatedStatus->getCode() === 55)  $openArchivalRequest->saveTaskStatus = "failed";
                            }
                            $openArchivalRequest->isValid = false;
                            $openArchivalRequest->save();
                            break;
                    }
                    continue;
                }

                if($updatedStatus['save_task_status'] !== $openArchivalRequest->saveTaskStatus){
                    $openArchivalRequest->updateFromCronGets($updatedStatus);
                }

                if($openArchivalRequest->swhIdList === null ){
                    self::addLogs($openArchivalRequest->originUrl." --> archival not finished");
                }
            }
        }
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param SoftwareHeritageRequest $openArchivalRequest
     * @return bool
     * @throws Exception
     */

    private static function isProlongedArchival(SoftwareHeritageRequest $openArchivalRequest): bool
    {
        $updated_at = new DateTime($openArchivalRequest->updated_at);

        $gracePeriod = clone $updated_at;

        $gracePeriod->add(new DateInterval("PT2H30M"));

        if($gracePeriod < new DateTime()) {
            self::addLogs("$openArchivalRequest->originUrl --> surpassed grace interval");

            event(new ProlongedArchival($openArchivalRequest));

            return true;
        }
        return false;
    }
}
