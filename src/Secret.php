<?php

namespace Bearcodi\DockerSecrets;

use Bearcodi\DockerSecrets\Exceptions\SecretNotFoundException;

class Secret
{
    protected $secret;

    public function __construct($secret)
    {
        if (! is_readable($secret)) {
            throw new SecretNotFoundException($secret);
        }

        $this->secret = $secret;
    }

    public function __toString()
    {
        return trim(file_get_contents($this->secret));
    }
}
