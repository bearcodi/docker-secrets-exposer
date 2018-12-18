<?php

namespace Bearcodi\DockerSecrets;

class DockerSecret
{
    protected $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    public function __invoke()
    {
        return (string) $this;
    }

    public function __toString()
    {
        return trim(file_get_contents($this->secret));
    }
}
