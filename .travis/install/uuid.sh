#!/usr/bin/env bash

# Load dependencies.
. ./shared.sh

# Install the UUID library.
must sudo apt-get install libuuid-dev

# Install PECL extension
yes '' | must sudo pecl install uuid

# Something is broken with Travis CI.
if [ '5.4' = "$TRAVIS_PHP_VERSION" ]; then
    must ln -s /usr/lib/php5/20090626/uuid.so /home/travis/.phpenv/versions/5.4.45/lib/php/extensions/no-debug-zts-20100525/uuid.so
fi
