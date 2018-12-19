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
        $nonExistantSecret = 'doesnt-exist';

        $this->expectException(SecretNotFoundException::class);

        $secret = new Secret($nonExistantSecret);
    }

    /** @test */
    public function it_exposes_a_secret_when_casted_or_interpolated_as_a_string()
    {
        $secretFile = $this->dockerSecretFile('pied', 'piper');

        $secret = new Secret($secretFile->dsn());

        $this->assertEquals($secretFile->content(), (string) $secret);
        $this->assertEquals($secretFile->content(), "$secret");
        $this->assertEquals($secretFile->content(), "{$secret}");
        $this->assertEquals($secretFile->content(), sprintf('%s', $secret));
    }

    /** @test */
    public function the_docker_secret_dsn_is_accessable()
    {
        $secretFile = $this->dockerSecretFile('pied', 'piper');

        $secret = new Secret($secretFile->dsn());

        $this->assertEquals('dockersecret://', Secret::DOCKER_SECRET_DSN);
        $this->assertEquals($secretFile->dsn(), $secret->dsn());
    }

    /** @test */
    public function it_can_check_if_a_string_is_a_valid_docker_secret_dsn()
    {
        $validDockerSecretDsn = Secret::DOCKER_SECRET_DSN.'valid';
        $invalidDockerSecretDsn = 'invalid';

        $this->assertTrue(Secret::check($validDockerSecretDsn));
        $this->assertFalse(Secret::check($invalidDockerSecretDsn));
    }

    /** @test */
    public function it_can_expose_a_docker_secret()
    {
        $secretFile = $this->dockerSecretFile('pied', 'piper');

        $secret = new Secret($secretFile->dsn());

        $this->assertEquals('piper', $secret->expose());
    }
}
