# LmcRbac

[![Version](https://poser.pugx.org/laminas-commons/lmc-rbac/version)](//packagist.org/packages/laminas-commons/lmc-rbac)
[![Total Downloads](https://poser.pugx.org/laminas-commons/lmc-rbac/downloads)](//packagist.org/packages/laminas-commons/lmc-rbac)
[![License](https://poser.pugx.org/laminas-commons/lmc-rbac/license)](//packagist.org/packages/laminas-commons/lmc-rbac)
[![Master Branch Build Status](https://travis-ci.org/Laminas-Commons/LmcRbac.svg?branch=master)](http://travis-ci.org/Laminas-Commons/LmcRbac)
[![Gitter](https://badges.gitter.im/LaminasCommons/community.svg)](https://gitter.im/LaminasCommons/community?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
[![Coverage Status](https://coveralls.io/repos/github/Laminas-Commons/LmcRbac/badge.svg?branch=master)](https://coveralls.io/github/Laminas-Commons/LmcRbac?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Laminas-Commons/LmcRbac/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Laminas-Commons/LmcRbac/?branch=master)

Role-based access control module to provide additional features on top of Zend\Permissions\Rbac

Based on [ZF-Commons/zfc-rbac](https://github.com/ZF-Commons/zfc-rbac) v3.x. If you are looking for the Laminas version
of zfc-rbac v2, please use [Laminas-Commons/LmcRbacMvc](https://github.com/Laminas-Commons/LmcRbacMvc).

**Work In Progress**

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
$ php composer.phar require laminas-commons/lmc-rbac:^1.0
```

Enable the module by adding `LmcRbac` key to your `application.config.php` file. Customize the module by copy-pasting
the `zfc_rbac.global.php.dist` file to your `config/autoload` folder.

## Documentation

The official documentation is available in the [/docs](docs/) folder.

You can also find some Doctrine entities in the [/data](data/) folder that will help you to more quickly take advantage
of LmcRbac.

## Support

- File issues at https://github.com/Laminas-Commons/LmcRbac/issues.
- Ask questions in the [LaminasCommons gitter](https://gitter.im/LaminasCommons/community) chat.
