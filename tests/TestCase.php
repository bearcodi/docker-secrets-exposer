<?php

namespace Tests;

use Orchestra\Testbench\TestCase as TestBase;
use Bearcodi\DockerSecrets\ServiceProvider;

class TestCase extends TestBase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
