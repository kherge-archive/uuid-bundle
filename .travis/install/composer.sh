#!/usr/bin/env bash

# Force the command to exit successfully.
function must
{
    "$@";

    STATUS=$?

    if [ 0 -ne $STATUS ]; then
        exit $STATUS
    fi
}

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
