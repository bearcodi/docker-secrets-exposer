<?php

namespace Bearcodi\DockerSecrets;

use Bearcodi\DockerSecrets\Secret;

class Secret
{
    const DOCKER_SECRET_DEFAULT_PATH = '/run/secrets/';

    const DOCKER_SECRET_DSN = 'dockersecret://';

    protected $original;

    protected $dockerSecretsPath;

    public function __construct($dockerSecretsPath = null)
    {
        $this->dockerSecretsPath = $dockerSecretsPath ? rtrim($dockerSecretsPath, '/') . '/' : self::DOCKER_SECRET_DEFAULT_PATH;
    }

    public function expand($config, $parentKey = '')
    {
        foreach ($config as $key => $value) {
            $compoundedKey = implode('.', array_filter([$parentKey, $key]));

            if (is_array($value)) {
                $this->expand($value, $compoundedKey);
            }

            if ($this->isDockerSecret($value)) {

                $this->attachDockerSecret($compoundedKey, $value);
            }
        }
    }

    protected function isDockerSecret($value)
    {
        return is_string($value) &&
               substr($value, 0, strlen(self::DOCKER_SECRET_DSN)) === self::DOCKER_SECRET_DSN;
    }

    protected function attachDockerSecret($key, $value)
    {
        $secretFile = str_replace(self::DOCKER_SECRET_DSN, $this->dockerSecretsPath, $value);
        config(["{$key}" => new DockerSecret($secretFile)]);
    }
}
