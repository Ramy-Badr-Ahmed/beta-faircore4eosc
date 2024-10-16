<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Modules\SwhApi\Repositories;

use Illuminate\Support\Str;

class Git extends Repository
{
    protected const BREAKPOINTS = ['tree', 'blob', 'releases', 'pull', 'commit'];


    protected function getPaths(): ?string
    {
        $pathArray = parent::getPathArray();

        if(count($pathArray) <= 2 || empty(array_intersect($pathArray, self::BREAKPOINTS))){
            return NULL;
        }

        static::setBreakpointPosition($pathArray);

        return self::analysePaths($pathArray);
    }

    protected function analysePaths(array $pathArray): ?string
    {
        if(static::$breakpointPosition === -1) return NULL;

        $pos = static::$breakpointPosition;

        $gitBreakpoint = parent::getBreakPoint($pathArray);

        parent::splitByBreakpoint('/'. ($pathArray[$pos] === 'releases' ? $gitBreakpoint."/".$pathArray[$pos+1] : $gitBreakpoint) .'/');

        return parent::$repositoryPath;
    }

    protected function setBaseRepositoryURL(): string
    {
        return sprintf('%s://%s%s', $this->decomposedURL['scheme'], $this->decomposedURL['host'],
            Str::of(parent::$repositoryBase)->replaceMatches('/-$/', "")
        );
    }

}
