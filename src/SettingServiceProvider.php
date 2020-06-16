<?php

namespace Dcat\Admin\Extension\Fourn\Setting;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $extension = Setting::make();

        if ($this->app->runningInConsole()) {

            $this->loadMigrationsFrom($extension->migrations());

            $this->publishes([
                __DIR__.'/../config/setting.php' => config_path('setting.php'),
                __DIR__.'/../resources/lang' => resource_path('lang'),
            ]);

        }

        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}