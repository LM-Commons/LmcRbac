---
sidebar_label: Concepts
sidebar_position: 2
title: Concepts
---

[Role-Based Access Control (RBAC)](https://en.wikipedia.org/wiki/Role-based_access_control)
is an approach to restricting system access to authorized users by putting emphasis
on roles and their permissions.

In the RBAC model:

- an **identity** has one of more roles.
- a **role** has one of more permissions.
- a **permission** is typically an action like "read", "write", "delete".
- a **role** can have **child roles** thus providing a hierarchy of roles where a role will inherit the permissions of all its child roles.

## Authorization

An identity will be authorized to perform an action, such as accessing a resource, if it is granted
the permission that controls the execution of the action.

For example, deleting an item could be restricted to identities that have at least one role that has the
`item.delete` permission.  This could be implemented by defining a `member` role that has the `item.delete` and assigning
this role of an authenticated user.

## Dynamic Assertions

In some cases, just checking if the identity has the `item.delete` permission is not enough.
It would also be necessary to check, for example, that the `item` belongs to the identity. Dynamic assertion allow
to specify some extra checks before granting access to perform an action such as, in this case, being the owner of the 
resource.

## Identities

An identity is typically provided by an authentication process within the application. 

Authentication is not in the scope of `LmcRbac` and it is assumed that an identity entity providing assigned roles
is available when using the authorization service. If no identity is available, as it would be the case when no user is "logged in",
then a guest role is assumed.




