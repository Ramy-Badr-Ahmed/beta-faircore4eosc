<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: LZI -- SWH API Client
 * @Repo: https://github.com/dagstuhl-publishing/beta-faircore4eosc
 */

namespace App\Modules\SwhApi;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

trait Logs
{
    public static bool $echoFlag = false;

    public static bool $logFileTimestamp = false;

    protected static ?LoggerInterface $logger = null;

    public static array $errorMessages;

    protected static function openLog(): void
    {
        self::$logger = Log::build([
            'driver' => 'daily',
            'path' => self::$logFileTimestamp ? storage_path("logs/" . now('Europe/Berlin')->format('Y-m-d-H-i-s') ."-swhAPI.log") : storage_path("logs/swh/api.log"),
            'level' => 'info',
            'days' => 14,
            'max_files' => 30,
            'ignore_exceptions' => false,
        ]);
    }

    public static function setLogOptions(...$options):void
    {
        if(isset($options['isVerbose']) && is_bool($options['isVerbose'])){
            self::$echoFlag = $options['isVerbose'];
        }

        if(isset($options['fileTimestamp']) && is_bool($options['fileTimestamp'])){
            self::$logFileTimestamp =  $options['fileTimestamp'];
            self::openLog();
        }
    }

    public static function addErrors(string $errorLog): void
    {
        if(!isset(self::$logger)) self::openLog();

        self::$logger->error($errorLog);

        self::$errorMessages[] = now()." --> ".$errorLog;

        if(self::$echoFlag){
            echo "\n".$errorLog."\n";
        }
    }

    public static function addLogs(string $infoLog): void
    {
        if(!isset(self::$logger)) self::openLog();

        self::$logger->info($infoLog);

        if(self::$echoFlag){
            echo "\n".$infoLog."\n";
        }
    }

    public static function getErrors(bool $stringFormat = false): array|string
    {
        $errorMessages = self::$errorMessages;
        self::$errorMessages = [];
        return $stringFormat
            ? implode("\n", $errorMessages)
            : $errorMessages;
    }

}
