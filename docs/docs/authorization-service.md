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

`Lmc\Rbac\Service\AuthorizationServiceInterface` defines the following methods:

#### `isGranted(?IdentityInterface $identity, string $permission, $context = null): bool`

Checks that the identity has is granted the permission for the (optional) context.

  | Parameter      | Description                                                                                                                                                                |
  |----------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
  | `$identity`    | The identity whose roles to checks. <br/>If `$identity` is null, then the `guest` is used. <br/>The `guest` role is definable via configuration and defaults to `'guest'`. |
  | `$permission`  | The permission to check against                                                                                                                                            |
  | `$context`     | A context that will be passed to dynamic assertions that are defined for the permission                                                                                    |

#### `setAssertions(array $assertions, bool $merge = false): void`

Allows to define dynamic assertions at run-time.

  | Parameter     | Description                                                                             |
  |---------------|-----------------------------------------------------------------------------------------|
  | `$assertions` | An array of assertions to merge or to replace                                           |
  | `$merge`      | if `true` the content of `$assertions` will be merged with existing assertions.         |


#### `setAssertion(string $permission, AssertionInterface|callable|string $assertion): void`
Allows to define a dynamic assertion at run-time.

  | Parameter     | Description                             |
  |---------------|-----------------------------------------|
  | `$permission` | Permission name                         |
  | `$assertion`  | The assertion to set for `$permission`  |

#### `hasAssertion(string $permission): bool`
Checks if the authorization has a dynamic assertion for a given permission.

  | Parameter     | Description              |
  |---------------|--------------------------| 
  | `$permission` | Permission name          |


#### `getAssertions(): array`

Returns all the dynamic assertions defined.

#### `getAssertion(string $permission): AssertionInterface|callable|string|null`

Returns the dynamic assertion for the give permission

  | Parameter     | Description                 |
  |---------------|-----------------------------|
  | `$permission` | Permission permission name  |

More on dynamic assertions can be found in the [Assertions](assertions.md) section.

More on the `guest` role can be found in the [Configuration](configuration.md) section.

## Injecting the Authorization Service

There are a few methods to inject the Authorization Service into your service.

### Using a factory

You can inject the AuthorizationService into your own objects using a factory. The Authorization Service
can be retrieved from the container using `'Lmc\Rbac\Service\AuthorizationServiceInterface'`. 

Here is a classic example for injecting the Authorization Service into your own service

*in your app's Module*

```php
use Lmc\Rbac\Service\AuthorizationServiceInterface;
class Module
{
    public function getConfig()
    {
        return [
            'service_manager' => [
                'factories' => [
                     'MyService' => function($sm) {
                         $authService = $sm->get('AuthorizationServiceInterface');
                        return new MyService($authService);
                        }
                ],
            ],
        ];
    }
}
````

### Using traits

For convenience, LmcRbac provides a `AuthorizationServiceAwareTrait` that adds the `$authorizationService` property and
setter/getter methods.

### Using delegators

LmcRbac ships with a `Lmc\Rbac\Service\AuthorizationServiceDelegatorFactory` [delegator factory](https://docs.laminas.dev/laminas-servicemanager/delegators/)
to automatically inject the authorization service into your classes.

Your class must implement the `Lmc\Rbac\Service\AuthorizationServiceAwareInterface` and use the above trait, as shown below:

```php
namespace MyModule;

use Lmc\Rbac\Service\AuthorizationServiceAwareInterface;
use Lmc\Rbac\Service\AuthorizationServiceAwareTrait;

class MyClass implements AuthorizationServiceAwareInterface
{
    use AuthorizationServiceAwareTrait;

    public function doSomethingThatRequiresAuth()
    {
        if (! $this->getAuthorizationService()->isGranted($identity, 'deletePost')) {
            throw new \Exception('You are not allowed !');
        }
        return true;
    }
}
```

And add your class to the right delegator:

```php
namespace MyModule;
use Lmc\Rbac\Service\AuthorizationServiceDelegatorFactory;
class Module
{
    // ...

    public function getConfig()
    {
        return [
            'service_manager' => [
                'factories' => [
                    MyClass::class => InvokableFactory::class,
                ],
                'delegators' => [
                    MyClass::class => [
                         AuthorizationServiceDelegatorFactory::class,               
                    ],
                ],
            ],
        ];
    }
}
```


