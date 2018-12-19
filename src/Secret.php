<?php

namespace Bearcodi\DockerSecrets;

use Bearcodi\DockerSecrets\Exceptions\SecretNotFoundException;

/**
 * Docker secret object.
 *
 * Used with Docker containers running in a Docker Swarm, you can
 * load and expose a Docker secret to your app.
 *
 * @example     `new \Bearcodi\DockerSecrets\Secret('dockersecret://super-secret')->expose()`
 */
class Secret
{
    /**
     * Docker secrets base path for Docker secrets.
     *
     * @see     https://docs.docker.com/engine/swarm/secrets/#how-docker-manages-secrets
     *
     * @var     string
     */
    const DOCKER_SECRETS_BASE_PATH = '/run/secrets/';

    /**
     * DOCKER_SECRET_DSN constant used to define a Docker secret strings.
     *
     * @var     string
     */
    const DOCKER_SECRET_DSN = 'dockersecret://';

    /**
     * The determined Docker secrets storage base path for secret files.
     *
     * @var     string
     */
    protected $dockerSecretsBasePath;

    /**
     * The qualified Docker secret name including the DOCKER_SECRET_DSN.
     *
     * @example dockersecret://super-secret
     *
     * @var     string
     */
    protected $dockerSecretDsn;

    /**
     * The file path of the actual Docker secret.
     *
     * @example /run/secrets/super-secret
     *
     * @var     string
     */
    protected $dockerSecretFilePath;

    /**
     * Attempt to locate a Docker secret.
     *
     * @param   string  $dockerSecretDsn
     *
     * @return  void
     */
    public function __construct($dockerSecretDsn)
    {
        $this->dockerSecretDsn = $dockerSecretDsn;

        $this->configureSecretBasePath()
             ->checkDockerSecretFileExists();
    }

    /**
     * Validates a passed Docker secret DSN string.
     *
     * @param   string  $value
     *
     * @return  bool
     */
    public static function check($value)
    {
        return is_string($value) &&
               substr($value, 0, strlen(self::DOCKER_SECRET_DSN)) === self::DOCKER_SECRET_DSN;
    }

    /**
     * Check that a Docker secret file exists.
     *
     * @throws  Bearcodi\DockerSecrets\Exceptions\SecretNotFoundException
     *
     * @return  self
     */
    public function checkDockerSecretFileExists()
    {
        $this->dockerSecretFilePath = str_replace(
            self::DOCKER_SECRET_DSN,
            $this->dockerSecretsBasePath,
            $this->dockerSecretDsn
        );

        if (! $this->check($this->dockerSecretDsn) || ! is_readable($this->dockerSecretFilePath)) {
            throw new SecretNotFoundException($this->dockerSecretDsn);
        }

        return $this;
    }

    /**
     * Configure the Docker secrets base path.
     *
     * This can be overridden using the `DOCKER_SECRETS_PATH` environment
     * variable. The default is set to the Docker secrets default path.
     *
     * @return  self
     */
    protected function configureSecretBasePath()
    {
        $basePathOverride = getenv('DOCKER_SECRETS_BASE_PATH');

        $this->dockerSecretsBasePath = $basePathOverride
            ? rtrim($basePathOverride, '/').'/'
            : self::DOCKER_SECRETS_BASE_PATH;

        return $this;
    }

    /**
     * Get the Docker secret DSN.
     *
     * @return  string
     */
    public function dsn()
    {
        return $this->dockerSecretDsn;
    }

    /**
     * Exposes the Docker secret.
     *
     * @return  string
     */
    public function expose()
    {
        return (string) $this;
    }

    /**
     * Read the Docker secret from the file.
     *
     * @return  string
     */
    public function __toString()
    {
        return trim(file_get_contents($this->dockerSecretFilePath));
    }
}
