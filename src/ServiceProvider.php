<?php

namespace Bearcodi\DockerSecrets;

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
    }
}
