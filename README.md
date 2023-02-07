# PAW: Php AnyWhere

Run PHP any version, anywhere.

## Usage

Based on the BusyBox principle, the [php](php) multi-call script is the main entrypoint.

The way it works is dead simple: php version is deduced from the called script name.

As a consequence each `php<version>`**<sup>(1)</sup>** symlink must point to the main [`php`](php) entrypoint script.

_If invoked without any version suffix, the default PHP version will be used: either the `PHP_VERSION`**<sup>(2)</sup>** environment variable (if set), the latest PHP GA release (currently 8.2) otherwise._

> **<sup>(1)</sup>** Version must be one of the following:
 `5.5`,
 `5.6`,
 `7.0`,
 `7.1`,
 `7.2`,
 `7.3`,
 `7.4`,
 `8.0`,
 `8.1`,
 `8.2`<br/>
> **<sup>(2)</sup>** See the [customizing](#customizing) section for more details.

### Usage examples

```bash
$ cd $HOME/bin
$ ln -s php php7.4
$ php7.4 --version
PHP 7.4.28 (cli) (built: Mar 29 2022 03:52:02) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
    with Zend OPcache v7.4.28, Copyright (c), by Zend Technologies
```

_The following examples are given assuming that:_
- _The `php` multi-call script is in one of the `$PATH` dirs_
- _A symlink to it has been created for each php version_


#### Open a php interactive command prompt

```bash
php7.4 -a
```

#### Open a bash session

```bash
php8.0
```

### Customizing

_The following environment variables allow to fine-tune the PAW script behaviour_

Name|Description|Fallback value
---|---|---
`PHP_VERSION`|The default version to use for `PHP`|`8.2`
`PAW_IMAGE`|Alternative docker image to use|[`yannoff/php-fpm`](https://github.com/yannoff/docker-php-fpm)
`PAW_DEBUG`|If set, turn on debug mode|-

## Credits

Licensed under the [MIT License](LICENSE).
