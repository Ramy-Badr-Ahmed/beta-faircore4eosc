<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Modules\SwhApi\DAGModel;

use App\Modules\SwhApi\DataType\SwhCoreID;
use Illuminate\Support\Collection;
use stdClass;
use Throwable;

interface SwhNodes
{

    public function which(): String|Throwable;

    public function nodeExists(): String|Bool|Throwable;

    public function nodeHopp(): Iterable|Collection|stdClass|Throwable;

    public function nodeEdges(): Iterable|Collection|stdClass|Throwable;

    public function nodeTargetEdge(string $targetName): SwhCoreID|Array|Throwable;

    public function nodeTraversal(string|array $target = null): SwhCoreID|stdClass|Throwable;

}
