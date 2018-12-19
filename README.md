# Docker Secrets Expander

[![Build Status](https://travis-ci.org/bearcodi/docker-secrets-exposer.svg?branch=master)](https://travis-ci.org/bearcodi/docker-secrets-exposer)
![laravel5.7](https://img.shields.io/badge/laravel-5.7-orange.svg?logo=laravel)
![php7](https://img.shields.io/badge/php-7.1-blue.svg)

A drop in package when using Laravel in a Docker Swarm setup and wanting to expand docker secrets easily.

## But why?

> Write a blurb about why you would want to use this, and why the value isn't just replaced or cached....security yo!!!

## Installation

Hey, we all like composer here right??

```bash
composer require bearcodi/docker-secrets
```

### Laravel setup

Its 2018, and Laravel is fun to dev packages for, is already setup!!!

### Non Laravel projects

Hmmmm, need to think about this for Code Igniter.

## Usage

Within you `.env` file, or from you `docker-compose.yml` stack file using environment variables, define your secret prefixing it with `dockersecrets://` DSN.

```bash
DB_PASSWORD=dockersecrets://db-password
```

> **IMPORTANT** If you are using a docker secret in your code not in a string context (ie. array key lookup)
> either cast it to a string `(string) config("CONFIG_KEY")` or use the `expose()` method on the return value as it is an instance of `Bearcodi\DockerSecrets\Secret`

The secret is then parsed and replaced with the Secret handler, when evalutated in a string usage the secret file value is returned on demand without exposing it in your applications environment.

## Laravel environment key exclusions

| Key | Reason for exclusion |
| :-  | :- |
| `DB_CONNECTION` | The value is used in an array key lookup when establishing the database connection driver, see array key lookups |
