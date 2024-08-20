---
sidebar_label: To LmcRbac v2
sidebar_position: 1
title: Upgrading to LmcRbac v2 
---

LmcRbac v2 is a major version upgrade with many breaking changes that prevent
straightforward upgrading.

### Namespace change

The namespace has been changed from LmcRbac to Lmc\Rbac.

Please review your code to replace references to the `LmcRbac` namespace
by the `Lmc\Rbac` namespace.

### Deprecations

- `Lmc\Rbac\HierarchicalRole` has been deprecated since `Lmc\Rbac\Role` now supports hierarchical roles. Flat roles
  are just a simplified version of a hierarchical roles. Use `Lmc\Rbac\Role` instead.
- The factories for services have been refactored from the `Lmc\Rbac\Container` namespace
  to be colocated with the service that a factory is creating. All factories in the `Lmc\Rbac\Container` namespace have 
been deprecated.
- The `AssertionContainer` class, interface and factory have been deprecated and replaced by `AssertionPluginManager` class, interface and factory.
