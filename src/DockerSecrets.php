<?php

namespace Bearcodi\DockerSecrets;

/**
 * Docker secrets resolver for app configuration.
 *
 * @version     0.1.0
 */
class DockerSecrets
{
    /**
     * Recursively parse a config array and attempt to resolve any docker secrets.
     *
     * @param   mixed   $config
     * @param   string  $parentKey  For recursively setting a nested config key
     *
     * @return  self
     */
    public function parse($config, $parentKey = '')
    {
        foreach ($config as $key => $value) {
            $compoundedKey = implode('.', array_filter([$parentKey, $key]));

            if (is_array($value)) {
                $this->parse($value, $compoundedKey);
            }

            $this->resolveDockerSecret($compoundedKey, $value);
        }

        return $this;
    }

    /**
     * Resolve a docker secret replacing the config string DSN.
     *
     * @param   string  $key        The config key to update, ie. app.name
     * @param   string  $secret     The secret DSN to evaluate.
     *
     * @return  Bearcodi\DockerSecrets\Secret
     */
    protected function resolveDockerSecret($key, $secret)
    {
        if (Secret::check($secret)) {
            config(["{$key}" => new Secret($secret)]);
        }
    }
}
