#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

REMOTE_NAME="ghcr.io/wesleyvestjens/php-devops-animal-training-test/php-fpm:base"

docker build \
  --pull \
  --cache-from "${REMOTE_NAME}" \
  -t "${REMOTE_NAME}" \
  docker/php-fpm/base

docker push "${REMOTE_NAME}"
