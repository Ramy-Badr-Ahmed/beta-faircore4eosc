<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: LZI -- SWH API Client
 * @Repo: https://github.com/dagstuhl-publishing/beta-faircore4eosc
 */

namespace App\Modules\SwhApi;


use Ds\Queue;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use stdClass;
use Throwable;
use TypeError;
use UnhandledMatchError;

class Archive extends SyncHTTP implements SwhArchive
{
    public const SUPPORTED_OPTIONS = ["withHeaders", "distinct"];

    private const VISIT_TYPES =[
        "git",
        "bzr",
        "hg",
        "svn",
    ];
    private const GITTYPE = 'git';

    private const BZRTYPE = 'bzr';

    private const HGTYPE = 'hg';

    private const SVNTYPE = 'svn';

    private const GITHUB = 'github.com';

    private const GITLAB = 'gitlab';

    private const BITBUCKET = 'bitbucket.org';

    private const GIT_BREAKPOINTS = ["tree", "blob", "releases", "pull", "commit"];

    private const BITBUCKET_BREAKPOINTS = ["src"];

    private const FULL_VISIT = "full";

    private const NOT_FOUND_VISIT = "not_found";

    private const ARCHIVAL_SUCCEEDED = "succeeded";

    private const ARCHIVAL_FAILED = 'failed';

    public array $decomposedURL = [];

    public array $nodeHits = [];

    protected stdClass $swhIDs;

    protected SwhVisits $visitObject;

    protected SwhOrigins $originObject;

    protected Archivable $archivable;


    /**
     * @param string $url
     * @param string|null $visitType
     * @param ...$options
     * @throws Exception|UnhandledMatchError
     */
    public function __construct(public string $url, public ?string $visitType = null, ...$options)
    {
        $this->processURL($this->url, $this->visitType);

        $this->archivable = new Archivable($this->url, $this->visitType);

        $this->visitObject = new SwhVisits($this->url);

        $this->originObject = new SwhOrigins($this->url);

        parent::__construct();

        self::setOptions(...$options);
    }

    /**
     * @param $url
     * @param $visitType
     * @return void
     * @throws Exception
     */
    public function getVisitType(&$url, &$visitType): void
    {
        $patternArray = [
            self::GITTYPE  => "/".self::GITTYPE."|" .self::BITBUCKET."/i",
            self::BZRTYPE  => "/(".self::BZRTYPE."\.)/i",
            self::HGTYPE   => "/(".self::HGTYPE."\.)/i",
            self::SVNTYPE  => "/(".self::SVNTYPE."\.)/i"
        ];

        if($visitType === null){
            foreach ($patternArray as $key => $pattern){
                if(preg_match($pattern, $this->decomposedURL['host'])){
                    if($key===self::GITTYPE){   //todo: unnecessary condition if we later support non-git types
                        $visitType = $key;
                        return;
                    }
                }
            }
        }
        if(!in_array(Str::of($visitType)->trim(), self::VISIT_TYPES)){
            throw new Exception("Unsupported Visit Type", 912);
        }
    }

    /**
     * @param array $decomposedURL
     * @return string|null
     */
    private function analyseBitbucket(array $decomposedURL): ?string
    {
        $pathArray = explode("/", substr($decomposedURL["path"], 1));

        if(count($pathArray)===2){
            return null;
        }

        $bitbucketBreakpoint  = Arr::first(self::BITBUCKET_BREAKPOINTS, function ($val) use($pathArray){
            return Str::is($val, $pathArray[2]);
        });

        $pathArray = explode('/'.$bitbucketBreakpoint.'/', $decomposedURL["path"]);

        $this->url = sprintf('%s://%s%s', $decomposedURL['scheme'], $decomposedURL['host'], $pathArray[0]);
        return $pathArray[1];
    }

    /**
     * @param array $decomposedURL
     * @return string|null
     */
    private function analyseGit(array $decomposedURL): ?string
    {
        $pathArray = explode("/", substr($decomposedURL["path"], 1));

        return match(true){
            count($pathArray) <= 2,
            empty(array_intersect($pathArray, self::GIT_BREAKPOINTS)) => Null,
            default => $this->analyseGitPaths($decomposedURL, $pathArray)
        };
    }

    /**
     * @param array $decomposedURL
     * @param array $pathArray
     * @return string
     */
    private function analyseGitPaths(array $decomposedURL, array $pathArray): string
    {
        $pos = array_search('-', $pathArray);
        $pos = $pos?:2;

        $pathArray[$pos] = preg_replace('/^-/i', $pathArray[$pos+1], $pathArray[$pos]);

        $gitBreakpoint  = Arr::first(self::GIT_BREAKPOINTS, function ($val) use($pathArray, $pos){
            return Str::is($val, $pathArray[$pos]);
        });

        $pathArray = explode('/'. ($pathArray[$pos] === 'releases' ? $gitBreakpoint."/".$pathArray[$pos+1] : $gitBreakpoint) .'/', $decomposedURL["path"]);

        $this->url = sprintf('%s://%s%s', $decomposedURL['scheme'], $decomposedURL['host'], Str::of($pathArray[0])->replaceMatches('/-$/', ""));
        return $pathArray[1];

    }

    /**
     * @return bool
     */
    private function isStillGitLab(): bool
    {
        $pendingURL = sprintf('%s://%s%s', $this->decomposedURL['scheme'], $this->decomposedURL['host'], "/help");

        $headResponse = Http::withOptions(['allow_redirects' => ['max' => 1]])->HEAD($pendingURL);

        return  array_key_exists('X-Gitlab-Meta', $headResponse->headers())
            || str_contains($headResponse->header("Set-Cookie"), "_gitlab_session")
            || str_contains(@file_get_contents($pendingURL), 'GitLab');
    }

    /**
     * @param string $url
     * @param string|null $visitType
     * @return void
     * @throws Exception|UnhandledMatchError
     */
    private function processURL(string &$url, ?string &$visitType): void
    {
        $url = Str::of($url)->trim();

        $this->decomposedURL = parse_url(preg_replace('/\/$/i',"", rawurldecode($url)));

        self::getVisitType($this->decomposedURL['host'], $visitType);

        try{
            $urlPath = match(Str::of($this->decomposedURL['host'])->match("/".self::GITLAB."|".self::GITHUB."|".self::BITBUCKET."/i")->value()){
                self::GITHUB, self::GITLAB => $this->analyseGit($this->decomposedURL),
                self::BITBUCKET => $this->analyseBitbucket($this->decomposedURL)
            };
        }catch (UnhandledMatchError $e){
            if($this->isStillGitLab()){
                $this->analyseGit($this->decomposedURL);
                return;
            }
            $this->addErrors("Non-supported repository URL: ".$url. ". If this was git or bitbucket, please report a bug");
            throw $e;
        }

        if(is_null($urlPath)){
            return;
        }

        self::addLogs("Archiving is considering repository arguments: ". preg_replace('/\//i',', ', $urlPath));

        $urlQueues["branchName"] = new Queue(array(substr($urlPath, 0, strpos($urlPath,"/" ) ? : Null)));

        if(Str::substrCount($urlPath, "/")===0){
            $this->nodeHits = $urlQueues;
            self::addLogs("Archiving is considering branch: ". implode("/", $urlQueues['branchName']->toArray()));
            return;
        }
        $urlQueues["path"] = new Queue(explode('/', substr($urlPath, strpos($urlPath, "/") +1 )));

        self::addLogs("Archiving is considering branch: ". implode("/", $urlQueues['branchName']->toArray()) .
            " and initial path: ". implode('/', $urlQueues['path']->toArray()));

        $this->nodeHits = $urlQueues;
    }

    /**
     * @param string $url
     * @return Archivable
     * @throws Exception
     */
    public static function of(string $url): Archivable
    {
        $archive = new self($url);

        return new Archivable($archive->url, $archive->visitType);
    }

    /**
     * @param ...$flags
     * @return iterable|Collection|stdClass|Throwable
     */
    public function save2Swh(...$flags): iterable|Collection|stdClass|Throwable
    {
        $responseType = self::$responseType;
        try{
            Helper::validateOptions($flags);

            $responseSave = $this->invokeEndpoint("POST",'save', collect([$this->url, $this->visitType]), ...$flags);

            if($responseSave instanceof Throwable){
                return $responseSave;
            }

            return $flags['withHeaders'] ?? false
                ? collect(["response"=>$responseSave->$responseType(), "headers" => $responseSave->headers()])
                : $responseSave->$responseType();

        }catch (RequestException $e){
            $this->addErrors($e->getCode().": " . match ($e->response->status()){
                400 => "An invalid Visit Type or URL: ". $this->visitType ." <--> ". $this->url,
                403 => "Origin URL: ". $this->url ." is black listed in SWH",
                default => $e->response->json()['reason'] ?? $e->response->body()
            });
            return $e;
        }catch(Exception $e){
            $this->addErrors($e->getCode().": ".$e->getMessage());
            return $e;
        }
    }


    /**
     * @param string|int $saveRequestDateOrID
     * @param ...$flags
     * @return iterable|Collection|stdClass|Throwable
     */
    public function getArchivalStatus(string|int $saveRequestDateOrID, ...$flags): iterable|Collection|stdClass|Throwable
    {
        try {
            $archivalRequest = $this->archivable->getFullArchivalRequest($saveRequestDateOrID, ...$flags);

            if ($archivalRequest instanceof Throwable) {
                return $archivalRequest;
            }

            $archivalRequest = Formatting::reCastTo($archivalRequest, self::RESPONSE_TYPE_ARRAY);

            if ($archivalRequest['save_task_status'] === self::ARCHIVAL_SUCCEEDED) {

                $traverseToDirectory = TreeTraversal::traverseFromSnp(new SwhCoreID($archivalRequest['snapshot_swhid']), $this->nodeHits);

                if($traverseToDirectory instanceof Throwable){
                    return $traverseToDirectory;
                }

                $originID = $this->originObject->getOriFromURL();

                $this->swhIDs = Helper::object_merge($originID instanceof SwhCoreID ? $originID : new stdClass(), $traverseToDirectory);

                $archivalRequest['swh_id_list'] = $this->swhIDs;

                $archivalRequest['contextual_swh_ids'] = Formatting::getContexts($this->swhIDs, $this->url, $this->nodeHits["path"] ?? null);
            }
            return $archivalRequest['save_task_status'] === self::ARCHIVAL_FAILED
                ? throw new Exception("Archival has failed with id: {$archivalRequest['id']} and save_request_date: {$archivalRequest['save_request_date']}", 55)
                : Formatting::reCastTo($archivalRequest, self::$responseType);

        }catch (TypeError|Exception $e){
            $this->addErrors($e->getCode().": ".$e->getMessage());
            return $e;
        }
    }

    /**
     * @param string|int $saveRequestDateOrID
     * @param ...$flags
     * @return iterable|Collection|stdClass|Throwable
     */
    public function trackArchivalStatus(string|int $saveRequestDateOrID, ...$flags): iterable|Collection|stdClass|Throwable
    {
        do{
            $archivalRequest = $this->getArchivalStatus($saveRequestDateOrID, ...$flags);

            if ($archivalRequest instanceof Throwable) {
                if(is_a($archivalRequest, TypeError::class)){
                    $done = false;
                    continue;
                }
                else{
                    return $archivalRequest;
                }
            }
            $archivalRequest = Formatting::reCastTo($archivalRequest, self::RESPONSE_TYPE_ARRAY);
            $done = $archivalRequest['save_task_status'] === self::ARCHIVAL_SUCCEEDED;
            self::addLogs("Done --> ".var_export($done, true)."\n");
        }while(!$done);

        return Formatting::reCastTo($archivalRequest, self::$responseType);
    }

    /**
     * @param string|int $saveRequestDateOrID
     * @param ...$flags
     * @return SwhCoreID|Throwable|Null
     */
    public function getSnpFromSaveRequest(string|int $saveRequestDateOrID): SwhCoreID|Null|Throwable
    {
        try {
            $archivalRequest = $this->archivable->getFullArchivalRequest($saveRequestDateOrID);

            if($archivalRequest instanceof Throwable){
                return $archivalRequest;
            }

            $archivalRequest = Formatting::reCastTo($archivalRequest, self::RESPONSE_TYPE_ARRAY);

            return $archivalRequest['save_task_status'] === self::ARCHIVAL_SUCCEEDED && $archivalRequest['visit_status'] === self::FULL_VISIT
                ? new SwhCoreID($archivalRequest['snapshot_swhid'])
                : $this->archivable->getSnpFromSaveRequestID($archivalRequest['id']);

        }catch (TypeError|Exception $e){
            $this->addErrors($e->getMessage());
            return $e;
        }
    }

    /**
     * @param ...$flags
     * @return iterable|Collection|stdClass|Throwable
     */
    public function getLatestArchivalAttempt(...$flags) : iterable|Collection|stdClass|Throwable
    {
        try {
            $latestVisit = $this->visitObject->getVisit("latest", ...$flags);

            if($latestVisit instanceof Throwable){
                return $latestVisit;
            }
            $latestVisit = Formatting::reCastTo($latestVisit, self::RESPONSE_TYPE_ARRAY);

            if($latestVisit['status'] === self::NOT_FOUND_VISIT){
                throw new Exception("Failed archival attempt for URL: $this->url");
            }
            $visitSnapshot = new SwhCoreID(Formatting::formatSwhIDs(Formatting::SWH_SNAPSHOT, $latestVisit['snapshot']));
            $visitDate = $latestVisit["date"];

            $allArchives = $this->archivable->getAllArchives();

            if($allArchives instanceof Throwable){
                return $allArchives;
            }
            $matchingArchival = Helper::grabMatching($allArchives, $visitDate);

            $traverseToDirectory = TreeTraversal::traverseFromSnp($visitSnapshot, $this->nodeHits);

            $originID = $this->originObject->getOriFromURL();

            $this->swhIDs = Helper::object_merge($originID instanceof SwhCoreID ? $originID : new stdClass(), $traverseToDirectory);

            $matchingArchival['swh_id_list'] = $this->swhIDs;
            $matchingArchival['contextual_swh_ids'] = Formatting::getContexts($this->swhIDs, $this->url, $this->nodeHits["path"] ?? null);

            return Formatting::reCastTo($matchingArchival, self::$responseType);

        }catch (TypeError|Exception $e){
            $this->addErrors($e->getCode().": ".$e->getMessage());
            return $e;
        }
    }
}
