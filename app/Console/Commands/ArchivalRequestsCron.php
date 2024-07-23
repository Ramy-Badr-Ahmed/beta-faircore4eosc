<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Console\Commands;

use App\Http\Controllers\Beta\CommandsController,
    Illuminate\Console\Command,
    Illuminate\Support\Arr;

class ArchivalRequestsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swh:updateCron {URLs?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update URLs Archival Status in DB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $urlString =  $this->argument('URLs');

        $urlArray = explode(',', $urlString);

        $urlArray = Arr::map($urlArray, function ($value) {
            return preg_replace('#/$#','', $value);
        });

        $urlArray = empty($urlArray[0]) ? null: $urlArray;

        CommandsController::requestsCron($urlArray);

        return parent::SUCCESS;
    }
}
