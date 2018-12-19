<?php

namespace Tests\Feature;

use Tests\TestCase;
use Bearcodi\DockerSecrets\Secret;
use Bearcodi\DockerSecrets\DockerSecrets;

class DockerSecretsTest extends TestCase
{

    /** @test */
    public function it_can_expand_a_docker_secret()
    {
        $dockerSecret = $this->dockerSecretFile('pied', 'piper');
        $configKey = 'docker.secret';

        config(["{$configKey}" => $dockerSecret->dsn()]);

        (new DockerSecrets())->parse(config()->all());

        $secret = config($configKey);

        $this->assertInstanceOf(Secret::class, $secret);

        $this->assertEquals('piper', (string) $secret);
    }

    /** @test */
    public function a_docker_secret_is_not_exposed_to_the_environment()
    {
        $envKey = 'DOCKER_SECRET';
        $configKey = 'docker.secret';
        $dockerSecret = $this->dockerSecretFile('pied', 'piper');

        putenv("{$envKey}={$dockerSecret->dsn()}");
        config(["{$configKey}" => $dockerSecret->dsn()]);
        (new DockerSecrets())->parse(config()->all());

        $this->assertInstanceOf(Secret::class, config($configKey));
        $this->assertEquals('piper', config($configKey)->expose());
        $this->assertEquals(getenv($envKey), $dockerSecret->dsn());
    }
}
