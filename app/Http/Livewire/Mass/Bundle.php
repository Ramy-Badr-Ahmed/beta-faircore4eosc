<?php

namespace App\Http\Livewire\Mass;

use App\Models\SoftwareHeritageRequest;
use App\Modules\SwhApi\Archival\Archive;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use PDOException;
use Throwable;
use UnhandledMatchError;

class Bundle extends Component
{
    public string $repos = "";

    public bool $errorred = false;

    public array $reposArray = [];

    protected array $unacceptedURLs = [];

    protected array $failedURLs = [];

    protected array $responses = [];

    protected SoftwareHeritageRequest $dbInstance;

    protected array $rules = [
        'repos' => 'required'
    ];

    protected array $messages = [
        'repos.required' => ':attribute field cannot be empty'
    ];

    protected array $validationAttributes = [
        'repos' => 'Repositories'
    ];

    protected bool $restricted = true;

    const EXTRACTED_PROPERTIES = [
        'id',
        'visit_type',
        'save_request_date',
        'save_request_status',
        'save_task_status',
        'loading_task_id',
    ];

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     */
    public function boot(): void
    {
        if(Auth::user()->has_role === 'admin') $this->restricted = false;
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return View|FoundationApplication|Factory|Application
     */

    public function render(): View|FoundationApplication|Factory|Application
    {
        return view('livewire.mass.bundle')
            ->with('time', now('Europe/Berlin'));
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @throws ValidationException
     */

    public function updatedRepos(): void
    {
        $this->resetValidation();

        $this->processRepos();

        $this->ensureURLsUpperbound();

        $this->reposArray = collect($this->reposArray)
            ->map(fn($url) => trim($url))
            ->reject(fn($url) => empty($url))
            ->unique()->values()
            ->toArray();

        $this->validateURLs();

        $this->repos = implode(',', $this->reposArray);
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     */

    private function processRepos(): void
    {
        $convertedRepos = explode(',', str_replace("\n", "," , $this->repos));

        $this->reposArray = Arr::map($convertedRepos, fn ($val) =>  $this->errorred
            ? substr($val, preg_match('/\s*\d\s*\)/', $val) ? strpos($val, ")")+1 : 0)
            : $val
        );
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @throws ValidationException
     */

    private function validateURLs(): void
    {
        $validator = Validator::make($this->reposArray, ['*' => 'url'], ['*'=> 'Entry #:position is a non-valid URL']);

        if($validator->fails()){
            $this->errorred = true;
            $this->repos = implode(',', collect($this->reposArray)->map(fn($val, $idx)=> ($idx+1).") ".$val)->all());
            throw ValidationException::withMessages(['repos' => implode('--', $validator->errors()->all())  ]);
        }
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @throws ValidationException
     */

    private function ensureURLsUpperbound(): void
    {
        if($this->restricted && count($this->reposArray) > 10){
            throw ValidationException::withMessages(['repos' => 'Ten repositories are maximally allowed at a time.' ]);
        }
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     */

    public function resetRepos(): void
    {
        $this->reset('repos', 'errorred');
        $this->resetValidation();
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     * @throws Throwable
     */

    public function archiveAllSequentially(): void
    {
        $this->validate();

        $this->validateURLs();

        $this->ensureURLsUpperbound();

        foreach ($this->reposArray as $repo){
            try{
                $this->ensureNonExistingRepo($repo);

                $newArchival = new Archive($repo);

                $saveResponse = $newArchival->save2Swh();

                if ($saveResponse instanceof Throwable){
                    $this->failedURLs [] = $repo." --> ".$saveResponse->getMessage();
                    continue;
                }

                $saveResponse["origin_url"] = $repo;

                $this->insert2DBSequentially($saveResponse);

                DB::commit();

            }catch (UnhandledMatchError | Throwable | PDOException | QueryException $e){

                DB::rollBack();

                Log::error($e->getMessage(). " in line: ". $e->getLine(). " in file ".$e->getFile());

                match(true){
                    $e instanceof UnhandledMatchError,
                        $e->getCode() === 912,
                        $e->getCode() === 913 => $this->unacceptedURLs [] = $repo." --> ".$e->getMessage(),

                    $e instanceof PDOException,
                        $e instanceof QueryException => $this->failedURLs [] = $repo." --> ".$e->getMessage(),

                    default => session()->flash('error-message', "Encountered an Internal Error while attempting archival of: ". $repo
                        ."<br>Please try again and kindly report it if the problem persists.")
                };
                continue;
            }
        }
        $this->flash();

        $this->emit('fetchAgain');

        $this->resetRepos();
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param string $url
     * @return void
     * @throws Throwable
     */

    private function ensureNonExistingRepo(string $url): void
    {
        $archivalRequest = SoftwareHeritageRequest::where(['originURL' => $url])
            ->where('createdBy_id', '=', Auth::user()->id)
            ->first();

        if (isset($archivalRequest)) {            //entry exists in db
            if (!isset($archivalRequest->swhIdList)) {
                throw new Exception('Exists with an unfinished archival Status. Please wait while we synchronise with SWH.', 913);
            } else {
                DB::beginTransaction();
                $archivalRequest->delete();
            }
        }
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param iterable $saveResponse
     * @return void
     */

    private function insert2DBSequentially(iterable $saveResponse): void
    {
        $this->dbInstance = new SoftwareHeritageRequest();
        $this->dbInstance->populateFromPostForm($saveResponse);
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     * @throws Throwable
     */

    public function archiveAllMassy(): void
    {
        $this->validate();

        $this->validateURLs();

        $this->ensureURLsUpperbound();

        $this->ensureNonExistingRepos();

        foreach ($this->reposArray as $repo){
            try{

                $newArchival = new Archive($repo);

                $saveResponse = $newArchival->save2Swh();

                if ($saveResponse instanceof Throwable){
                    $this->failedURLs [] = $repo." --> ".$saveResponse->getMessage();
                    continue;
                }

                $saveResponse = Arr::only((array)$saveResponse, self::EXTRACTED_PROPERTIES);
                $saveResponse["origin_url"] = $repo;

                $this->responses [] = $saveResponse;

            }catch (UnhandledMatchError | Throwable $e){

                Log::error($e->getMessage(). " in line: ". $e->getLine(). " in file ".$e->getFile());

                match(true){
                    $e instanceof UnhandledMatchError,
                        $e->getCode() === 912 => $this->unacceptedURLs [] = $repo." --> ".$e->getMessage(),

                    default => session()->flash('error-message', "Encountered an Internal Error while attempting archival of: ". $repo
                        ."<br>Please try again and kindly report it if the problem persists.")
                };
                continue;
            }
        }

        try{
            $this->insertMassy2DB();

            DB::commit();

        }catch (Throwable $e){
            DB::rollBack();
        }

        $this->flash();

        $this->emit('fetchAgain');

        $this->resetRepos();
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     * @throws Throwable
     */

    private function ensureNonExistingRepos(): void
    {
        $archivalRequests = SoftwareHeritageRequest::whereIn('originURL', $this->reposArray)
            ->where('createdBy_id', '=', Auth::user()->id)
            ->get();

        if (isset($archivalRequests)) {            //entries exists in db
            DB::beginTransaction();
            $archivalRequests->each->delete();
        }
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     */

    private function insertMassy2DB(): void
    {
        try{
            $succeeded = SoftwareHeritageRequest::massAssign($this->responses);

            if(!$succeeded){
                throw new Exception('Data creation failed');
            }

        }catch (PDOException | QueryException | Exception $e){
            $this->failedURLs = Arr::pluck($this->responses, 'origin_url');
            throw $e;
        }

    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return void
     */

    private function flash(): void
    {
        if(!empty($this->unacceptedURLs)) {
            session()->flash('warning-message', "Unaccepted URL(s):<br>".implode('<br>', $this->unacceptedURLs));

            if(count($this->reposArray) === count($this->unacceptedURLs)) return;
        }
        if(!empty($this->failedURLs)){
            session()->flash('error-message', "Failed URL(s):<br>".implode('<br>', $this->failedURLs).
                "<br>DB Internal error. Kindly report that to us. Thank you!");

            if(count($this->reposArray) === count($this->failedURLs)) return;
        }

        session()->flash('success-message', "Archival in progress. Fetching...");
    }
}
