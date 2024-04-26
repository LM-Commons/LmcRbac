# LmcRbac

[![Build](https://github.com/lm-commons/LmcRbac/actions/workflows/build_test.yml/badge.svg)](https://github.com/lm-commons/LmcRbac/actions/workflows/build_test.yml)
[![Version](https://poser.pugx.org/lm-commons/lmc-rbac/v)](https://packagist.org/packages/lm-commons/lmc-rbac)
[![Total Downloads](https://poser.pugx.org/lm-commons/lmc-rbac/downloads)](//packagist.org/packages/lm-commons/lmc-rbac)
[![License](https://poser.pugx.org/lm-commons/lmc-rbac/license)](https://packagist.org/packages/lm-commons/lmc-rbac)
[![Coverage Status](https://coveralls.io/repos/github/LM-Commons/LmcRbac/badge.svg?branch=master)](https://coveralls.io/github/LM-Commons/LmcRbac?branch=master)
[![Static Badge](https://img.shields.io/badge/Chat_on-Slack-blue)](https://join.slack.com/t/lm-commons/shared_invite/zt-2gankt2wj-FTS45hp1W~JEj1tWvDsUHQ)

Role-based access control module to provide additional features on top of Zend\Permissions\Rbac

Based on [ZF-Commons/zfc-rbac](https://github.com/ZF-Commons/zfc-rbac) v3.x. If you are looking for the Laminas version
of zfc-rbac v2, please use [LM-Commons/LmcRbacMvc](https://github.com/LM-Commons/LmcRbacMvc).

## Requirements

- PHP 7.2 or higher

## Optional

- [DoctrineModule](https://github.com/doctrine/DoctrineModule): if you want to use some built-in role and permission providers.
- [Laminas\DeveloperTools](https://github.com/zendframework/Laminas\DeveloperTools): if you want to have useful stats added to
the Laminas Developer toolbar.

## Upgrade

You can find an [upgrade guide](UPGRADE.md) to quickly upgrade your application from major versions of LmcRbac.

## Installation

LmcRbac only officially supports installation through Composer. For Composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

Install the module:

```sh
$ php composer.phar require lm-commons/lmc-rbac
```

Enable the module by adding `LmcRbac` key to your `application.config.php` file. Customize the module by copy-pasting
the `config.global.php` file to your `config/autoload` folder.

## Documentation

The official documentation is available [here](https://lm-commons.github.io/LmcRbac) folder.

You can also find some Doctrine entities in the [/data](/data) folder that will help you to more quickly take advantage
of LmcRbac.

## Support

- File issues at https://github.com/LM-Commons/LmcRbac/issues.
- Ask questions in the [LM-Commons Slack](https://join.slack.com/t/lm-commons/shared_invite/zt-2gankt2wj-FTS45hp1W~JEj1tWvDsUHQ) chat.
