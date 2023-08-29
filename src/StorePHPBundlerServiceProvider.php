<?php

namespace StorePHP\Bundler;

use Illuminate\Support\ServiceProvider;
use StorePHP\Bundler\Console\SetupCommand;

class StorePHPBundlerServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
            ]);
        }
    }
}
