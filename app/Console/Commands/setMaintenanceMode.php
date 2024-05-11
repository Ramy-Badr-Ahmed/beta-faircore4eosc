<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class setMaintenanceMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:maintenance-mode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Maintenance Parameters';

    protected string $configPath;

    protected string $configContents;

    protected string $envPath;

    protected string $envContents;

    public function __construct()
    {
        $this->configPath = config_path('app.php');
        $this->configContents = File::get($this->configPath);

        $this->envPath = base_path('.env');
        $this->envContents = File::get($this->envPath);

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $configContents = preg_replace("/'enforce_https'\s*=>\s*(.+)/", "'enforce_https' => false,", $this->configContents);
        File::put($this->configPath, $configContents);

        $envContents = preg_replace_array("/APP_DEBUG\s*=\s*(.+)|(?<!#)APP_URL|(?<!#)ASSET_URL/", ["APP_DEBUG=true", "#APP_URL", "#ASSET_URL"], $this->envContents);
        File::put($this->envPath, $envContents);

        Artisan::call('config:clear');

        $this->info("\nApp in Maintenance Mode.\n");

        $this->table(['Parameter', 'Value'],
            [   ["HTTPS", Str::of($configContents)->match("/'enforce_https'\s*=>\s*([^,]+)/")->value()],
                [""],
                ['APP_URL', Str::of($envContents)->match("/(#APP_URL\s*=\s*.+)/")->value()],
                [""],
                ['ASSET_URL', Str::of($envContents)->match("/(#ASSET_URL\s*=\s*.+)/")->value()],
                [""],
                ['APP_DEBUG', Str::of($envContents)->match("/APP_DEBUG\s*=\s*(.+)/")->value()]
            ]
        );
    }
}
