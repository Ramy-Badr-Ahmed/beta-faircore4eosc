<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Modules\SwhApi\Global;

use App\Modules\SwhApi\HTTPConnector\HTTPClient;
use Exception;
use Illuminate\Support\Arr;
use stdClass;

abstract class Helper
{

    /**
     * @throws Exception
     */
    public static function validateOptions(array $options) : void
    {
        $class = debug_backtrace()[1]["class"];

        if(array_diff(array_keys($options), array_merge($class::SUPPORTED_OPTIONS, HTTPClient::SUPPORTED_OPTIONS)) ){   // if(!empty)
            throw new Exception("Unrecognised options. Supported flags for "
                .substr($class, strrpos($class, "\\")+1)." are: " .implode(", ", $class::SUPPORTED_OPTIONS) );
        }
        foreach (Arr::only($options, $class::SUPPORTED_OPTIONS) as $key=>$value){
            if(!is_bool($value)){
                throw new Exception("Received type: '". gettype($value) ."' Expected 'boolean' option type.");
            }
        }
    }

    /**
     * @param ...$objects
     * @return stdClass
     */
    public static function object_merge(...$objects): stdClass
    {
        $mergedArray=[];
        foreach ($objects as $object){
            $mergedArray = array_merge($mergedArray, get_object_vars($object));
        }
        $mergedObject = new stdClass();
        foreach($mergedArray as $key => $value) {
            $mergedObject->$key = $value;
        }
        return $mergedObject;
    }

    /**
     * @param mixed $allData
     * @param string|int $searchCriterion
     * @return iterable|Null
     */
    public static function grabMatching(mixed $allData, string|int $searchCriterion): iterable|Null
    {
        $allData = Formatting::reCastTo($allData, HTTPClient::RESPONSE_TYPE_ARRAY);

        return Arr::first($allData, function ($datum) use ($searchCriterion) {

            return boolval(Arr::where($datum, function ($value) use ($searchCriterion){
                return is_numeric($searchCriterion)
                    ? (int)$value === (int)$searchCriterion
                    : $value === $searchCriterion;
            }));
        });
    }

}
