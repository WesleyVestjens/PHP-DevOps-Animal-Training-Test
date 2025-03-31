#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

minikube start --output=json --wait=all --namespace=default
kubectl config use minikube
