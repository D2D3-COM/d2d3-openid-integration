<?php
namespace D2d3\OpenidIntegration;

use D2d3\OpenidIntegration\Http\Console\Commands\OpenIdSyncUser;
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
