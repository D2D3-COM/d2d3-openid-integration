<?php
namespace D2d3\OpenId;

use D2d3\OpenId\Http\Console\Commands\OpenIdSyncUser;
use Illuminate\Support\ServiceProvider;

class OpenIdServiceProvider extends ServiceProvider
{
  public function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        OpenIdSyncUser::class,
      ]);
    }
  }
  public function register(){}
}
