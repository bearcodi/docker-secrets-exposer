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

    /** @test */
    public function it_exposes_a_secret_when_casted_or_interpolated_as_a_string()
    {
        $secretFile = $this->dockerSecretFile('pied', 'piper');

        $secretValue = trim(file_get_contents($secretFile));

        $secret = new Secret($secretFile);

        $this->assertEquals($secretValue, (string) $secret);
        $this->assertEquals($secretValue, "$secret");
        $this->assertEquals($secretValue, "{$secret}");
        $this->assertEquals($secretValue, sprintf("%s", $secret));
    }
}
