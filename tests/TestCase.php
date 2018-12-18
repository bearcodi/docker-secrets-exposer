<?php

namespace Tests;

use Bearcodi\DockerSecrets\ServiceProvider;
use Orchestra\Testbench\TestCase as TestBase;

class TestCase extends TestBase
{
    protected function dockerSecretFile($secret)
    {
        return __DIR__ . '/fixtures/secrets/' . $secret;
    }
    /**
     * Set our docker secrets path to the 'fixtures/secrets' folder for testing.
     *
     * @return  void
     */
    public static function setUpBeforeClass()
    {
        putenv('DOCKER_SECRETS_PATH=' . __DIR__ . '/fixtures/secrets/');
    }

    /**
     * Add our package service provider.
     *
     * @param   \Illuminate\Foundation\Application $app
     *
     * @return  mixed
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
