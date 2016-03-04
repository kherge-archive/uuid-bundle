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

# Update package list.
must sudo apt-get update

# Install build packages.
must sudo apt-get install make build-essential automake php5-dev php-pear

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
