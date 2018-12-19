<?php

namespace Tests\Feature;

use Tests\TestCase;
use Bearcodi\DockerSecrets\Secret;
use Bearcodi\DockerSecrets\DockerSecrets;

class DockerSecretsTest extends TestCase
{
    /** @test */
    // public function it_can_expand_a_docker_secret()
    // {
    //     $dockerSecret = 'dockersecret://pied';
    //
    //     config(['DOCKER_SECRET' => $dockerSecret]);
    //
    //     (new DockerSecrets())->parse(config()->all());
    //
    //     $secret = config('DOCKER_SECRET');
    //
    //     $this->assertInstanceOf(Secret::class, $secret);
    //
    //     $this->assertEquals('piper', (string) $secret);
    // }
}
