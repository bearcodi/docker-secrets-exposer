<?php

namespace Tests\Unit;

use Tests\TestCase;
use Bearcodi\DockerSecrets\Secret;
use Bearcodi\DockerSecrets\Exceptions\SecretNotFoundException;

class SecretTest extends TestCase
{
    /** @test */
    public function it_throws_a_secret_not_found_exception_when_the_passed_secret_file_is_not_readable()
    {
        $nonExistantSecretFile = '/run/secrets/doesnt-exist';

        $this->expectException(SecretNotFoundException::class);

        $secret = new Secret($nonExistantSecretFile);
    }
}
