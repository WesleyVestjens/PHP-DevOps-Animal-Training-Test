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
