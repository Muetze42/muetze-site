<?php


namespace NormanHuth\Muetze;

use Illuminate\Support\ServiceProvider;
use NormanHuth\Muetze\Commands\MigrateMakeCommand;
use NormanHuth\Muetze\Commands\ModelMakeCommand;

class SiteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrateMakeCommand::class,
                ModelMakeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../stubs/laravel' => base_path('stubs'),
        ], 'laravel-stubs');

        $this->publishes([
            __DIR__.'/../stubs/nova' => base_path('stubs/nova'),
        ], 'nova-stubs');

        $locationPath = resource_path('lang/vendor/muetze-site');
        $locationTarget = $locationPath.'/'.app()->getLocale().'.json';

        $this->publishes([
            __DIR__.'/../resources/lang/de.json' => $locationTarget,
        ], 'translations');

        if (file_exists($locationTarget)) {
            $this->loadJSONTranslationsFrom($locationPath);
        }
    }
}
