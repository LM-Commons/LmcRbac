# LmcRbac

[![Build](https://github.com/lm-commons/LmcRbac/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/lm-commons/LmcRbac/actions/workflows/continuous-integration.yml)
[![Version](https://poser.pugx.org/lm-commons/lmc-rbac/v)](https://packagist.org/packages/lm-commons/lmc-rbac)
[![Total Downloads](https://poser.pugx.org/lm-commons/lmc-rbac/downloads)](//packagist.org/packages/lm-commons/lmc-rbac)
[![License](https://poser.pugx.org/lm-commons/lmc-rbac/license)](https://packagist.org/packages/lm-commons/lmc-rbac)

![Dynamic JSON Badge](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fapi.github.com%2Frepos%2Flm-commons%2Flmcrbac%2Fproperties%2Fvalues&query=%24%5B%3A1%5D.value&label=Maintenance%20Status)

Role-based access control module to provide additional features on top of
Laminas\Permissions\Rbac

## Requirements

- PHP 8.2 or higher

## Optional

- [DoctrineModule](https://github.com/doctrine/DoctrineModule): if you want to
use some built-in role and permission providers.

## Upgrade

You can find an [upgrade guide](UPGRADE.md) to quickly upgrade your application
from major versions of LmcRbac.

## Installation

LmcRbac only officially supports installation through Composer. For Composer
documentation, please refer to [getcomposer.org](http://getcomposer.org/).

Install the module:

```sh
$ composer require lm-commons/lmc-rbac
```

Enable the module by adding `LmcRbac` key to your `application.config.php` file.
Customize the module by copy-pasting the `config.global.php` file to your
`config/autoload` folder.

## Documentation

The official documentation is available
[here](https://lm-commons.github.io/LmcRbac) folder.

You can also find some Doctrine entities in the [/data](/data) folder that will
help you to more quickly take advantage of LmcRbac.

## Support

- File issues at on [github](https://github.com/LM-Commons/LmcRbac/issues).
- Ask questions on [the LM-Commons Discord](https://discord.gg/nAAu7AhR).
