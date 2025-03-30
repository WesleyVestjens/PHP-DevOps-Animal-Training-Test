#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

REMOTE_NAME="ghcr.io/wesleyvestjens/php-devops-animal-training-test/nginx:base"

docker build \
  --pull \
  --cache-from "${REMOTE_NAME}" \
  -t "${REMOTE_NAME}" \
  docker/nginx/base

docker push "${REMOTE_NAME}"
