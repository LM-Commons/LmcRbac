---
title: Integrating into applications
---

LmcRbac can be used in your application to implement role-based access control.

However, it is important to note that Authorization service `isGranted()` method expects
an identity to be provided. The identity must also implement the `Lmc\Rbac\Identity\IdentityInterface`.

User authentication is not in the scope of LmcRbac and must be implemented by your application.

## Laminas MVC applications

In a Laminas MVC application, you can use the ['laminas-authentication'](https://docs.laminas.dev/laminas-authentication) 
component with an appropriate adapter to provide the identity.

The `Laminas\Authentication\AuthenticationService` service provides the identity using the `getIdentity()` method. 
However, it is not prescriptive on the signature of the returned identity object. It is up to the
authentication adapter to return a authentication result that contains an identity object that implements the 
`IdentityInterface`.

For example:

```php
<?php
namespace MyApp;

use \Laminas\Authentication\AuthenticationService;
use \Lmc\Rbac\Service\AuthorizationServiceAwareTrait;

class MyClass
{
    use AuthorizationServiceAwareTrait;
    protected AuthenticationService $authenticationService;
    
    public function __construct($authenticationService, $authorizationService) 
    {
        $this->authenticationService = $authenticationService;
        $this->authorizationService = $authorizationService;
    }
    
    public function doSomething() 
    {
        $identity = $this->authenticationService->hasIdentity() ? $this->authenticationService->getIdentity() : null;
        
        // Check for permission
        if ($this->getAuthorizationService()->isGranted($identity, 'somepermssion')) {
            // authorized
        } else {
            // not authorized
        }
    }
    
}

```
### Other Laminas MVC components to use
To facilitate integration in an MVC application, you can use [LmcUser](https://lm-commons.github.io/LmcUser/) for 
authentication.

You can also use [LmcRbacMvc](https://lm-commons.github.io/LmcRbacMvc/) which extends LmcRbac by handling identities.
It also provides additional functionalities like route guards and strategies for handling unauthorized access. For example,
an unauthorized strategy could be to redirect to a login page. 

## Mezzio and PSR-7 applications

In a Mezzio application, you can use the [`mezzio/mezzio-authentication`](https://docs.mezzio.dev/mezzio-authentication/) 
component to provide the identity. `mezzio/mezzio-authentication` will add a `UserInterface` object to the request attributes.

From this point, assuming that you have configured your application to use the `Mezzio\Authentication\AuthenticationMiddleware`,
you can use `MyUser` in your handler by retrieving it from the request:

```php
// Retrieve the UserInterface object from the request.
$user = $request->getAttribute(UserInterface::class);

// Check for permission, this works because $user implements IdentityInterface
if ($this->getAuthorizationService()->isGranted($user, 'somepermssion')) {
    // authorized
} else {
    // not authorized
}
```

How you define roles and permissions in your application is up to you. One way would be to use the route name as
a permission such that authorization can be set up based on routes and optionally on route+verb.


### Other Mezzio components to use

A LmcRbac Mezzio component is under development to provide factories and middleware to facilitate integration of LmcRbac
in Mezzio applications.
