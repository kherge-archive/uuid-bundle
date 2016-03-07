#!/usr/bin/env bash

# Find myself.
HERE="$(dirname "$0")"

# Load dependencies.
. "$HERE/shared.sh"

# Install default dependencies.
must composer install

# Install specific version of Symfony if specified.
if [ '' != "$SYMFONY_VERSION" ]; then
    must composer require --dev --no-update \
        symfony/config=${SYMFONY_VERSION} \
        symfony/dependency-injection=${SYMFONY_VERSION} \
        symfony/http-kernel=${SYMFONY_VERSION}
fi
