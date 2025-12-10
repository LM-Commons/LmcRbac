---
sidebar_label: Configuration
sidebar_position: 7
title: Configuring LmcRbac
---

LmcRbac is configured via the `lmc_rbac` key in the application config. 

This is typically achieved by creating 
a `config/autoload/lmcrbac.global.php` file. A sample configuration file is provided in the `config/` folder.

## Reference

| Key | Description                                                                                                                                    |
|--|------------------------------------------------------------------------------------------------------------------------------------------------|
| `guest_role` | Defines the name of the `guest` role when no identity exists. <br/>Defaults to `'guest'`.                                                      |
| `role_provider` | Defines the role provider.<br/>Defaults to `[]`<br/>See the [Role Providers](role-providers) section.                                          |
| `assertion_map` | Defines the dynamic assertions that are associated to permissions.<br/>Defaults to `[]`.<br/>See the [Dynamic Assertions](assertions) section. |
| `assertion_manager` | Provides a configuration for the Assertion Plugin Manager.<br/> Defaults to `[]`.<br/>See the [Dynamic Assertion](assertions.md) section.     |
