<?php

namespace D2d3\OpenId\Http\Console\Commands;

use D2d3\OpenId\Http\Services\SyncDataService;
use Illuminate\Console\Command;

class OpenIdSyncUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openid:sync-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "-----------------------Start sync-----------------";
        echo "\n";
        $result = SyncDataService::syncUser();
        print_r($result);
        echo "\n";
        echo "-----------------------Sync complete--------------";
        echo "\n";
        return true;
    }
}
