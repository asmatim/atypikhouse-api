#!/bin/sh

echo "Starting keycloak..."

nohup ./keycloak-15.0.2/bin/standalone.sh -b 0.0.0.0 &>/dev/null & sleep 1
