<?php

namespace StorePHP\Bundler;

use Illuminate\Support\ServiceProvider;
use StorePHP\Bundler\BundlesManagement;
use StorePHP\Bundler\Components\Form\CheckboxField;
use StorePHP\Bundler\Components\Form\DateField;
use StorePHP\Bundler\Components\Form\SelectField;
use StorePHP\Bundler\Components\Form\TextareaField;
use StorePHP\Bundler\Components\Form\TextField;
use StorePHP\Bundler\Components\FormBuilder;
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
        $this->app->bind('bundles', function ($app) {
            return new BundlesManagement();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'storephp-bundler');

        $this->loadViewComponentsAs('store-php', $this->viewComponents());

        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
            ]);
        }
    }

    private function viewComponents(): array
    {
        return [
            FormBuilder::class,
            
            TextField::class,
            SelectField::class,
            TextareaField::class,
            DateField::class,
            CheckboxField::class,
        ];
    }
}
