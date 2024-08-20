---
sidebar_label: Authorization service
sidebar_position: 5
title: Authorization Service
---

### Usage

The Authorization service can be retrieved from the service manager using the name
`Lmc\Rbac\Service\AuthorizationServiceInterface` and injected into your code:

```php
<?php
    /** @var \Psr\Container\ContainerInterface $container */
    $authorizationService = $container->get(Lmc\Rbac\Service\AuthorizationServiceInterface::class);

```
### Reference

`Lmc\Rbac\Service\AuthorizationServiceInterface` defines the following method:

- `isGranted(?IdentityInterface $identity, PermissionInterface|string $permission, $context = null): bool`
  | Parameter                                                           | Description                                                                                                                                                                |
  |----------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
  | `$identity` | The identity whose roles to checks. <br/>If `$identity` is null, then the `guest` is used. <br/>The `guest` role is definable via configuration and defaults to `'guest'`. |
  | `$permission` | The permission to check against                                                                                                                                            |
  | `$context` | A context that will be passed to dynamic assertions that are defined for the permission                                                                                   |

- `setAssertions(array $assertions, bool $merge = false): void`
  | Parameter     | Description                                                                             |
  |---------------|-----------------------------------------------------------------------------------------|
  | `$assertions` | An array of assertions to merge or to replace                                           |
  | `$merge`      | if `true` the content of `$assertions` will be merged with existing assertions.         |

- `setAssertion(PermissionInterface|string $permission, AssertionInterface|callable|string $assertion): void`
  | Parameter     | Description                            |
  |---------------|----------------------------------------|
  | `$permission` | Permission or a permission name        |
  | `$assertion`  | The assertion to set for `$permission` |

- `hasAssertion(PermissionInterface|string $permission): bool`
  | Parameter     | Description                            |
  |---------------|----------------------------------------| 
  | `$permission` | Permission or a permission name        |

- `getAssertions(): array`

- `getAssertion(PermissionInterface|string $permission): AssertionInterface|callable|string|null`
  | Parameter     | Description                            |
  |---------------|----------------------------------------|
  | `$permission` | Permission or a permission name        |

More on dynamic assertions can be found in the [Assertions](assertions.md) section.

More on the `guest` role can be found in the [Configuration](configuration.md) section.

