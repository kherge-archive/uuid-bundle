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

# Install PECL extension
yes '' | must sudo pecl install uuid
