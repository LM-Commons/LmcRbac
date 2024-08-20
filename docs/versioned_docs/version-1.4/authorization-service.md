---
sidebar_label: Authorization service
sidebar_position: 5
title: Authorization Service
---

### Usage

The Authorization service can be retrieved from the service manager using the name
`LmcRbac\Service\AuthorizationServiceInterface` and injected into your code:

```php
<?php
    /** @var \Psr\Container\ContainerInterface $container */
    $authorizationService = $container->get(LmcRbac\Service\AuthorizationServiceInterface::class);

```
### Reference

`LmcRbac\Service\AuthorizationServiceInterface` defines the following method:

- `isGranted(?IdentityInterface $identity, string $permission, $context = null): bool`

| Parameter                                                           | Description                                                                                                                                                                |
|----------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$identity` | The identity whose roles to checks. <br/>If `$identity` is null, then the `guest` is used. <br/>The `guest` role is definable via configuration and defaults to `'guest'`. |
| `$permission` | The permission to check against                                                                                                                                            |
| `$context` | A context that will be passed to dynamic assertions that are defined for the permission                                                                                   |

More on dynamic assertions can be found in the [Assertions](assertions.md) section.

More on the `guest` role can be found in the [Configuration](configuration.md) section.

