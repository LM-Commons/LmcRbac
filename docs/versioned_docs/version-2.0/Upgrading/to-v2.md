---
sidebar_label: From v1 to v2
sidebar_position: 1
title: Upgrading from v1 to v2 
---

LmcRbac v2 is a major version upgrade with many breaking changes that prevent
straightforward upgrading.

### Namespace change

The namespace has been changed from LmcRbac to Lmc\Rbac.

Please review your code to replace references to the `LmcRbac` namespace
by the `Lmc\Rbac` namespace.

### LmcRbac is based on laminas-permissions-rbac

LmcRbac is now based on the role class and interface provided by laminas-permissions-rbac which
provides a hierarchical role model only. 

Therefore the `Role`, `HierarchicalRole` classes and the `RoleInterface` and `HierarchicalRoleInterface` have been removed
in version 2.

The `PermissionInterface` interface has been removed as permissions in `laminas-permissions-rbac` as just strings or any 
objects that can be casted to a string. If you use objects to hold permissions, just make sure that the object can be
casted to a string by, for example, implementing a `__toString()` method.

### Refactoring the factories

The factories for services have been refactored from the `LmcRbac\Container` namespace
to be colocated with the service that a factory is creating. All factories in the `LmcRbac\Container` namespace have
been removed.

### Refactoring the Assertion Plugin Manager

The `AssertionContainer` class, interface and factory have been replaced by `AssertionPluginManager` class, interface and factory.
