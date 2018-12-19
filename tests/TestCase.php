<?php

namespace Tests;

use Tests\DockerSecretFile;
use Bearcodi\DockerSecrets\ServiceProvider;
use Orchestra\Testbench\TestCase as TestBase;

class TestCase extends TestBase
{
    /**
     * Creates a docker secret file
     * @param  [type] $secret [description]
     * @param  [type] $value  [description]
     * @return [type]         [description]
     */
    protected function dockerSecretFile($secret, $value = null)
    {
        return new DockerSecretFile($secret, $value);
    }

    /**
     * Set our docker secrets path to the 'fixtures/secrets' folder for testing.
     *
     * @return  void
     */
    public static function setUpBeforeClass()
    {
        putenv('DOCKER_SECRETS_BASE_PATH=' . DockerSecretFile::dockerSecretStoragePath());
    }

    /**
     * Cleanup our docker secrets after each test.
     *
     * @return  void
     */
    public function tearDown()
    {
        parent::tearDown();

        if (!! getenv('CLEANUP_TEST_DOCKER_SECRETS')) {
            DockerSecretFile::cleanup();
        }
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
