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
        $envKey = 'DOCKER_SECRET';

        config(["{$envKey}" => $dockerSecret->dsn()]);

        (new DockerSecrets())->parse(config()->all());

        $secret = config($envKey);

        $this->assertInstanceOf(Secret::class, $secret);

        $this->assertEquals('piper', (string) $secret);
    }

}
