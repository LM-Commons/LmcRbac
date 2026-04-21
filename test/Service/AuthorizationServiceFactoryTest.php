<?php

declare(strict_types=1);

namespace LmcTest\Rbac\Service;

use Laminas\Permissions\Rbac\Rbac;
use Lmc\Rbac\Assertion\AssertionPluginManager;
use Lmc\Rbac\Assertion\AssertionPluginManagerInterface;
use Lmc\Rbac\Options\ModuleOptions;
use Lmc\Rbac\Service\AuthorizationServiceFactory;
use Lmc\Rbac\Service\RoleServiceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

#[CoversClass(AuthorizationServiceFactory::class)]
class AuthorizationServiceFactoryTest extends TestCase
{
    public function testCanCreateAuthorizationService(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(4))->method('get')
            ->willReturnMap(
                [
                    [ModuleOptions::class, new ModuleOptions([])],
                    [RoleServiceInterface::class, $this->createStub(RoleServiceInterface::class)],
                    [AssertionPluginManagerInterface::class, new AssertionPluginManager($container)],
                    [Rbac::class, new Rbac()],
                ]
            );
        $factory = new AuthorizationServiceFactory();
        $factory($container);
    }
}
