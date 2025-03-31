#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

helm upgrade --install \
  --namespace default \
  app \
  ./deploy/app/ \
  --atomic
