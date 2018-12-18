<?php

namespace Bearcodi\DockerSecrets;

use Bearcodi\DockerSecrets\DockerSecrets;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
    * Perform post-registration booting of services.
    *
    * @return void
    */
    public function boot()
    {
        (new DockerSecrets())->parse(config()->all());
        // $this->publishes([
        //     __DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
        // ]);

    }

    /**
    * Register bindings in the container.
    *
    * @return void
    */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__.'/path/to/config/courier.php', 'courier'
        // );
    }
}
