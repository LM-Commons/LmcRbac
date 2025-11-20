<?php

declare(strict_types=1);

namespace Lmc\Rbac\Assertion;

use Override;
use Psr\Container\ContainerInterface;

interface AssertionPluginManagerInterface extends ContainerInterface
{
    #[Override]
    public function get(string $id): AssertionInterface;
}
