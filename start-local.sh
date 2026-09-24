#!/bin/bash
set -euo pipefail

export PATH="/Applications/Docker.app/Contents/Resources/bin:$PATH"

if ! docker info >/dev/null 2>&1; then
    echo "Starting Docker Desktop..."
    open -a Docker
    for i in $(seq 1 60); do
        if docker info >/dev/null 2>&1; then
            break
        fi
        sleep 2
    done
fi

docker compose up --build
