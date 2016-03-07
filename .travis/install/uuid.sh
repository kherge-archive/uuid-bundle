#!/usr/bin/env bash

# Find myself.
HERE="$(dirname "$0")"

# Load dependencies.
. "$HERE/shared.sh"

# Install the UUID library.
must sudo apt-get install uuid uuid-dev

# Install PECL extension
yes '' | must pecl install uuid
