<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Console\Commands;

use App\Models\User;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PDOException;

class DeleteUnverifiedAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unverified-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unverified accounts after a day';

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    /**
     * @return void
     */

    public function handle(): void
    {
        try {
            $unverifiedAccounts = User::whereNull('email_verified_at')->get();

            if(count($unverifiedAccounts->all()) === 0) return;

            foreach ($unverifiedAccounts as $unverifiedAccount){
                $created_at = new DateTime($unverifiedAccount->created_at);

                $gracePeriod = clone $created_at;

                $gracePeriod->add(new DateInterval("P0Y1DT0H0M"));

                if($gracePeriod < new DateTime()){
                    $unverifiedAccount->delete();
                    self::addLogs('Unverified Account Deleted: '.$unverifiedAccount->email);
                }
            }
        }catch (PDOException | Exception $e){
            self::addLogs('Command failed: '.$e->getMessage());
        }
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    /**
     * @param string $infoLog
     * @return void
     */

    public static function addLogs(string $infoLog): void
    {
        Log::channel('accountsLogs')->info($infoLog);
    }
}
