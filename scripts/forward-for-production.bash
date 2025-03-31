#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

TARGET_PORT=30123

echo "Open you browser to: http://$(minikube ip):${TARGET_PORT}/api/translation-matrix"
echo
echo "You can post to: http://$(minikube ip):${TARGET_PORT}/api/translate with header: content-type=application/json"
echo
echo "  Body/JSON: {\"sourceLanguage\":\"auto\",\"targetLanguage\":\"parrot\",\"input\":\"Hello there!\"}"

echo
echo "E.g.:"
echo

curl -Ls \
  -X POST \
  -H 'content-type: application/json' \
  --data '{"sourceLanguage":"auto","targetLanguage":"parrot","input":"Hello there!"}' \
  http://$(minikube ip):${TARGET_PORT}/api/translate | jq
