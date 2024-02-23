#!/bin/bash
#
# This file is part of PAW (https://github.com/yannoff/p-a-w)
#
# Copyright (c) 2023-present Yann Blacher (Yannoff)
#
# The PAW project is subject to the MIT License use-terms.
# @see https://github.com/yannoff/p-a-w/blob/main/LICENSE
#

image=${PAW_IMAGE}

called=$(basename $0)
version=${called//php/}

[ -z "${version}" ] && version=${PHP_VERSION:-8.3}
[ -z "${image}" ] && image=yannoff/php-fpm

_exec() {
    [ -n "${PAW_DEBUG}" ] && echo "$*" >&2
    # If stdout is not the terminal,
    # suppress carriage returns from output
    if [ -p /dev/stdout ] || [ -f /dev/stdout ]
    then
        "$@" | tr -d "\r"
    else
        "$@"
    fi
}

args=()

if [ "$#" -gt "0" ]
then
    # If first arg is an option, assume "php" is implicit
    # This allow calling the script in the form: bin/php -a
    if [ "${1#-}" != "$1" ]
    then
        set -- php "$@"
    else
        # If first arg is an absolute path, mount it
        [ "${1:0:1}" = "/" ] && args+=( -v ${1}:${1} )
    fi
else
    # If no command or option specified, open a bash session
    set -- bash
fi

# Mount current host directory to container working dir
args+=( -v ${PWD}:/app )
args+=( -w /app )

# Mount user/group accounts as read-only
args+=( -v /etc/group:/etc/group:ro )
args+=( -v /etc/passwd:/etc/passwd:ro )
args+=( -v /etc/shadow:/etc/shadow:ro )

# Mount user's composer home if it exists
[ -d $HOME/.composer ] && args+=( -v $HOME/.composer:/.composer )

# Mount user's ssh directory if it exists
[ -d $HOME/.ssh ] && args+=( -v $HOME/.ssh:$HOME/.ssh )

# Remove container after run
args+=( --rm )

# Run container in interactive mode
args+=( --interactive )

# If STDIN is not a pipe or a regular file, allocate a pseudo TTY
[ -p /dev/stdin ] || [ -f /dev/stdin ] || args+=( --tty )

# Run as standard, low-priviledged user
args+=( -u $(id -u):$(id -g) )

_exec docker run "${args[@]}" ${image}:${version} "$@"
