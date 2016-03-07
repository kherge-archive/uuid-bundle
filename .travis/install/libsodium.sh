#!/usr/bin/env bash

# Find myself.
HERE="$(dirname "$0")"

# Load dependencies.
. "$HERE/shared.sh"

# Update package list.
must sudo apt-get update

# Install build packages.
must sudo apt-get install make build-essential automake

# Clone libsodium repository.
must git clone git://github.com/jedisct1/libsodium.git
must cd libsodium

# Checkout the latest version.
must git checkout 1.0.8

# Build libsodium.
must ./autogen.sh
must ./configure
must make

# Install libsodium.
must sudo make install

# Install PECL extension
must sudo pecl install libsodium

# Something is broken with Travis CI.
if [ '5.4' = "$TRAVIS_PHP_VERSION" ]; then
    must ln -s /usr/lib/php5/20090626/libsodium.so /home/travis/.phpenv/versions/5.4.45/lib/php/extensions/no-debug-zts-20100525/libsodium.so
fi
