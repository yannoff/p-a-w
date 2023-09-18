# P A W

Run PHP. Any version. Without install.

## Get it

> _**Important note:** This script is designed to run on Linux and requires [docker](https://docs.docker.com/engine/install/) to be installed._

Get the latest release from github...

```bash
# $BINDIR may be any of the $PATH directories, eg: ~/bin, /usr/local/bin, etc... 
curl -Lo $BINDIR/php https://github.com/yannoff/p-a-w/releases/latest/download/php
# Make the main script executable
chmod +x $BINDIR/php
```

...add support for the desired php versions

```bash
ln -s $BINDIR/php $BINDIR/php5.6
ln -s $BINDIR/php $BINDIR/php7.4
ln -s $BINDIR/php $BINDIR/php8.0
```

..and **that's it !**

## How it works

Based on the  multi-call binary principle (as the well-known [BusyBox](https://busybox.net/about.html) project) , each `php<version>` **<sup>(1)</sup>** file is just a symlink pointing to the main [`php`](php) entrypoint script: PHP version is deduced from the invoked filename.

> _**<sup>(1)</sup>** If invoked without any suffix, the default version will be used: either the [`PHP_VERSION`](#customizing) env var (if set), the latest GA release (currently 8.2) otherwise._ 

Hence, adding support for a PHP version is dead-simple: just create a new `php<version>` **<sup>(2)</sup>** symlink to the main [`php`](php) script.

_For example:_

```bash
# Assume ~/bin is in the $PATH system-wide environment variable
~/bin $ ln -s php php7.4
# Now PHP 7.4 can be accessed from everywhere in the system
~/bin $ cd /some/other/path
/some/other/path $ php7.4 --version
PHP 7.4.28 (cli) (built: Mar 29 2022 03:52:02) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
    with Zend OPcache v7.4.28, Copyright (c), by Zend Technologies
```

> _**<sup>(2)</sup>** Version must be one of the following:
 `5.5`,
 `5.6`,
 `7.0`,
 `7.1`,
 `7.2`,
 `7.3`,
 `7.4`,
 `8.0`,
 `8.1`,
 `8.2`,
> `8.3-rc`_

## Examples

_The following examples are given assuming that:_
- _The `php` multi-call script is in one of the `$PATH` dirs_
- _A symlink to it has been created for each php version_


#### Open a php interactive command prompt

_Open a PHP 8.0 interactive shell in the current directory_

```bash
php8.0 -a
```

#### Open a bash session

_Open a PHP 8.2 container-secluded bash session, with access to the current directory_

```bash
php8.2
```

### Customizing

_The following environment variables allow to fine-tune the PAW script behaviour_

Name|Description|Fallback value
---|---|---
`PHP_VERSION`|The default version to use for `PHP`|`8.2`
`PAW_IMAGE`|PHP docker image to leverage|[`yannoff/php-fpm`](https://github.com/yannoff/docker-php-fpm) **<sup>(3)</sup>**
`PAW_DEBUG`|If set, turn on debug mode|-

> _**<sup>(3)</sup>** Based on [Alpine](https://www.alpinelinux.org/), this image uses `musl-libc`, [which implementation differs](https://wiki.musl-libc.org/functional-differences-from-glibc.html) from `glibc` on some aspects._

## Credits

Licensed under the [MIT License](LICENSE).
