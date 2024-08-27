<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

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
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

#[CoversClass(RoleService::class)]
class RoleServiceTest extends TestCase
{
    use ProphecyTrait;

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
        $roleProvider = $this->prophesize(RoleProviderInterface::class);
        $roleProvider->getRoles(Argument::any())->shouldNotBeCalled();

        $roleService = new RoleService($roleProvider->reveal(), 'guest');
        $roles       = [new Role('first'), new Role('second'), new Role('third')];
        $identity    = new Identity($roles);

        $result = $roleService->getIdentityRoles($identity);

        $this->assertCount(3, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals($roles, $result);
    }

    public function testWillCollectRolesOnlyIfRequired(): void
    {
        $roleProvider = $this->prophesize(RoleProviderInterface::class);
        $roles        = [new Role('first'), new Role('second'), 'third'];
        $roleProvider->getRoles(['third'])->shouldBeCalled()->willReturn([new Role('third')]);

        $roleService = new RoleService($roleProvider->reveal(), 'guest');
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

        //$roleService->setGuestRole('foo');
        //$this->assertEquals('foo', $roleService->getGuestRole());
    }
}
