#!/usr/bin/env bash

# Find myself.
HERE="$(dirname "$0")"

# Load dependencies.
. "$HERE/shared.sh"

# Install default dependencies.
must composer install

# Install specific version of Symfony if specified.
if [ '' != "$SYMFONY_VERSION" ]; then
    must composer require --dev --no-update symfony/symfony=$SYMFONY_VERSION
fi

# Install random_compat on older versions of PHP.
if [ '7.0' != "$TRAVIS_PHP_VERSION" ]; then
    must composer require paragonie/random_compat
fi
