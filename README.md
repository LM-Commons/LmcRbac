# LmcRbac

[![Version](https://poser.pugx.org/lm-commons/lmc-rbac/v)](https://packagist.org/packages/lm-commons/lmc-rbac)
[![Total Downloads](https://poser.pugx.org/lm-commons/lmc-rbac/downloads)](//packagist.org/packages/lm-commons/lmc-rbac)
[![License](https://poser.pugx.org/lm-commons/lmc-rbac/license)](https://packagist.org/packages/lm-commons/lmc-rbac)
[![Master Branch Build Status](https://travis-ci.com/LM-Commons/LmcRbac.svg?branch=master)](http://travis-ci.org/LM-Commons/LmcRbac)
[![Gitter](https://badges.gitter.im/Lm-Commons/community.svg)](https://gitter.im/LmCommons/community?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
[![Coverage Status](https://coveralls.io/repos/github/LM-Commons/LmcRbac/badge.svg?branch=master)](https://coveralls.io/github/LM-Commons/LmcRbac?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LM-Commons/LmcRbac/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LM-Commons/LmcRbac/?branch=master)

Role-based access control module to provide additional features on top of Zend\Permissions\Rbac

Based on [ZF-Commons/zfc-rbac](https://github.com/ZF-Commons/zfc-rbac) v3.x. If you are looking for the Laminas version
of zfc-rbac v2, please use [LM-Commons/LmcRbacMvc](https://github.com/LM-Commons/LmcRbacMvc).

## Requirements

- PHP 7.2 or higher

## Optional

- [DoctrineModule](https://github.com/doctrine/DoctrineModule): if you want to use some built-in role and permission providers.
- [Laminas\DeveloperTools](https://github.com/zendframework/Laminas\DeveloperTools): if you want to have useful stats added to
the Zend Developer toolbar.

## Upgrade

You can find an [upgrade guide](UPGRADE.md) to quickly upgrade your application from major versions of LmcRbac.

## Installation

LmcRbac only officially supports installation through Composer. For Composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

Install the module:

```sh
$ php composer.phar require lm-commons/lmc-rbac:^1.1
```

Enable the module by adding `LmcRbac` key to your `application.config.php` file. Customize the module by copy-pasting
the `config.global.php` file to your `config/autoload` folder.

## Documentation

The official documentation is available in the [/docs](docs/) folder.

You can also find some Doctrine entities in the [/data](data/) folder that will help you to more quickly take advantage
of LmcRbac.

## Support

- File issues at https://github.com/LM-Commons/LmcRbac/issues.
- Ask questions in the [LM-Commons gitter](https://gitter.im/Lm-Commons/community) chat.
