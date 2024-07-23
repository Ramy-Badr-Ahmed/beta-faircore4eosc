<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Modules\SwhApi\Archival;

use App\Modules\SwhApi\DataType\SwhCoreID;
use Illuminate\Support\Collection;
use stdClass;
use Throwable;

interface SwhArchive
{

    public function save2Swh(...$flags): iterable|Collection|stdClass|Throwable;

    public function getArchivalStatus(string|int $saveRequestDateOrID, ...$flags): iterable|Collection|stdClass|Throwable;

    public function trackArchivalStatus(string|int $saveRequestDateOrID, ...$flags): iterable|Collection|stdClass|Throwable;

    public function getSnpFromSaveRequest(string|int $saveRequestDateOrID): SwhCoreID|Null|Throwable;

    public function getLatestArchivalAttempt(...$flags) : iterable|Collection|stdClass|Throwable;

}
