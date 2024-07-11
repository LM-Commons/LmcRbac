---
sidebar_label: Getting Started
sidebar_position: 1
title: Get started
---
## Requirements

- PHP 7.3 or higher

:::warning
The code is continuously tested against PHP 8.1 and higher only. There is no warranty that it will work for PHP 8.0 and lower.
:::

## Installation

LmcRbac only officially supports installation through Composer.

Install the module:

```sh
$ composer require lm-commons/lmc-rbac "~1.0"
```

You will be prompted by the `laminas-component-installer` plugin to inject LM-Commons\LmcRbac.

:::note
**Manual installation:**

Enable the module by adding `LmcRbac` key to your `application.config.php` or `modules.config.php` file for Laminas MVC 
applications, or to the `config/config.php` file for Mezzio applications.
:::

Customize the module by copy-pasting
the `lmcrbac.global.php` file to your `config/autoload` folder.
