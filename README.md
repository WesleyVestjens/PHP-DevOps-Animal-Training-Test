PHP & DevOps training and testing project
=========================================

This is a PHP & DevOps training and testing project. The setup is intended to gauge the knowledge of the test taker into
various skills needed for PHP API development & DevOps tasks.

# Stack

The stack used is:

* Mezzio-Laminas for the PHP API
* Docker, minikube & Kubernetes for DevOps tasks
* GitHub Actions for CI/CD purposes

# Task

For information about the task at hand, see [the goal documentation](docs/goal.md).

# Docker structure

Each type of container (nginx, php-fpm) has a separate directory. Each directory contains various layers:

* `base`: this is the base layer for each image and focuses mainly on dependencies and configuration that is applicable
  for all environments.
* `dev`: this is an image that extends `base` and contains additional instructions for development.
* `production`: this is an image that extends `base` and contains additional instructions for production environments.

# Setup / getting started

Setup / getting started is easy.

1. Checkout the repository on your device
2. Run `docker compose up -d` to run the containers.
3. Run `bin/composer install` to install Composer dependencies.
4. Open [localhost/api/ping](http://localhost/api/ping)

# Running linting and testing:

Linting: `bin/phpcs`

Testing: `bin/phpunit`

# API documentation

## Getting the translation matrix

The translation matrix can be found on `/api/translation-matrix`. The expected response body is as follows:

```json
{
  "matrix": [
    {
      "source": "human",
      "targets": [
        "labrador",
        "poodle",
        "parrot",
        "parakeet"
      ]
    },
    {
      "source": "labrador",
      "targets": [
        "poodle",
        "parrot"
      ]
    },
    {
      "source": "poodle",
      "targets": [
        "labrador",
        "parrot"
      ]
    },
    {
      "source": "parrot",
      "targets": []
    },
    {
      "source": "parakeet",
      "targets": [
        "parrot"
      ]
    }
  ]
}
```

## Requesting translations for user input

To request translations for user input, make a POST call to `/api/translate`.

Required header: `content-type: application/json`

Required body:

```json
{
  "sourceLanguage": "auto",
  "targetLanguage": "parrot",
  "input": "Hello there!"
}
```

The expected response body is as follows:

```json
{
  "sourceLanguage": "auto",
  "targetLanguage": "parrot",
  "input": "Hello there!",
  "output": "Ik praat je na: Hello there!"
}
```

# Semi-production environment

To run a semi-production environment (deploy to Minikube), run the following scripts:

1. `/scripts/start-minikube.bash` > This will start a local Minikube cluster.
2. Request an ImagePullSecret from the repository owner and create the supplied secret in the `default` namespace with
   the name `github-registry`.
3. `/scripts/deploy-to-production.bash` > This will perform a deployment to the local Minikube cluster.
4. `/scripts/forward-for-production.bash` > This will output the correct URL for your local device/local Minikube
   cluster, and show some developer information to help you perform requests against this environment.
