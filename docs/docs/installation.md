---
sidebar_label: Requirements and Installation
sidebar_position: 2
---
# Requirements and Installation
## Requirements

- PHP 7.3 or higher


## Installation

LmcRbac only officially supports installation through Composer. For Composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

Install the module:

```sh
$ composer require lm-commons/lmc-rbac:^1.1
```

Enable the module by adding `LmcRbac` key to your `application.config.php` file. Customize the module by copy-pasting
the `config.global.php` file to your `config/autoload` folder.

You can also find some Doctrine entities in the [data](https://github.com/LM-Commons/LmcRbac/tree/master/data) folder that will help you to more quickly take advantage
of LmcRbac.
