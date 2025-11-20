<?php

declare(strict_types=1);

namespace LmcTest\Rbac\Service;

use Laminas\Permissions\Rbac\Role;
use Laminas\Permissions\Rbac\RoleInterface;
use Lmc\Rbac\Role\InMemoryRoleProvider;
use Lmc\Rbac\Role\RoleProviderInterface;
use Lmc\Rbac\Service\RoleService;
use LmcTest\Rbac\Asset\Identity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RoleService::class)]
class RoleServiceTest extends TestCase
{
    public function testReturnGuestRoleIfNoIdentityIsGiven(): void
    {
        $roleService = new RoleService(new InMemoryRoleProvider([]), 'guest');

        $result = $roleService->getIdentityRoles(null);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals('guest', $result[0]->getName());
    }

    public function testReturnGuestRoleIfNullIdentityIsGiven(): void
    {
        $roleService = new RoleService(new InMemoryRoleProvider([]), 'guest');

        $result = $roleService->getIdentityRoles(null);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals('guest', $result[0]->getName());
    }

    public function testWillNotInvokeRoleProviderIfAllRolesCollected(): void
    {
        $roleProvider = $this->createMock(RoleProviderInterface::class);
        $roleProvider->expects($this->never())->method('getRoles');

        $roleService = new RoleService($roleProvider, 'guest');
        $roles       = [new Role('first'), new Role('second'), new Role('third')];
        $identity    = new Identity($roles);

        $result = $roleService->getIdentityRoles($identity);

        $this->assertCount(3, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals($roles, $result);
    }

    public function testWillCollectRolesOnlyIfRequired(): void
    {
        $roleProvider = $this->createMock(RoleProviderInterface::class);
        $roleProvider->expects($this->once())->method('getRoles')
            ->with(['third'])
            ->willReturn([new Role('third')]);
        $roles = [new Role('first'), new Role('second'), 'third'];

        $roleService = new RoleService($roleProvider, 'guest');
        $identity    = new Identity($roles);

        $result = $roleService->getIdentityRoles($identity);

        $this->assertCount(3, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);

        $this->assertEquals($roles[0]->getName(), $result[0]->getName());
        $this->assertEquals($roles[1]->getName(), $result[1]->getName());
        $this->assertEquals($roles[2], $result[2]->getName());
    }

    public function testGuestRoleSetterGetter(): void
    {
        $roleService = new RoleService(new InMemoryRoleProvider([]), 'guest');
        $this->assertEquals('guest', $roleService->getGuestRole());
    }
}
