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

namespace LmcRbacTest\Service;

use LmcRbac\Identity\IdentityInterface;
use LmcRbac\Identity\IdentityProviderInterface;
use LmcRbac\Role\InMemoryRoleProvider;
use LmcRbac\Role\Role;
use LmcRbac\Role\RoleInterface;
use LmcRbac\Role\RoleProviderInterface;
use LmcRbac\Service\RoleService;
use LmcRbacTest\Asset\Identity;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @covers \LmcRbac\Service\RoleService
 */
class RoleServiceTest extends TestCase
{
    use ProphecyTrait;

    public static function roleProvider(): array
    {
        return [
            // No identity role
            [
                'rolesConfig' => [],
                'identityRoles' => [],
                'rolesToCheck' => [
                    'member',
                ],
                'doesMatch' => false,
            ],

            // Simple
            [
                'rolesConfig' => [
                    'member' => [
                        'children' => ['guest'],
                    ],
                    'guest',
                ],
                'identityRoles' => [
                    'guest',
                ],
                'rolesToCheck' => [
                    'member',
                ],
                'doesMatch' => false,
            ],
            [
                'rolesConfig' => [
                    'member' => [
                        'children' => ['guest'],
                    ],
                    'guest',
                ],
                'identityRoles' => [
                    'member',
                ],
                'rolesToCheck' => [
                    'member',
                ],
                'doesMatch' => true,
            ],

            // Complex role inheritance
            [
                'rolesConfig' => [
                    'admin' => [
                        'children' => ['moderator'],
                    ],
                    'moderator' => [
                        'children' => ['member'],
                    ],
                    'member' => [
                        'children' => ['guest'],
                    ],
                    'guest',
                ],
                'identityRoles' => [
                    'member',
                    'moderator',
                ],
                'rolesToCheck' => [
                    'admin',
                ],
                'doesMatch' => false,
            ],
            [
                'rolesConfig' => [
                    'admin' => [
                        'children' => ['moderator'],
                    ],
                    'moderator' => [
                        'children' => ['member'],
                    ],
                    'member' => [
                        'children' => ['guest'],
                    ],
                    'guest',
                ],
                'identityRoles' => [
                    'member',
                    'admin',
                ],
                'rolesToCheck' => [
                    'moderator',
                ],
                'doesMatch' => true,
            ],

            // Complex role inheritance and multiple check
            [
                'rolesConfig' => [
                    'sysadmin' => [
                        'children' => ['siteadmin', 'admin'],
                    ],
                    'siteadmin',
                    'admin' => [
                        'children' => ['moderator'],
                    ],
                    'moderator' => [
                        'children' => ['member'],
                    ],
                    'member' => [
                        'children' => ['guest'],
                    ],
                    'guest',
                ],
                'identityRoles' => [
                    'member',
                    'moderator',
                ],
                'rolesToCheck' => [
                    'admin',
                    'sysadmin',
                ],
                'doesMatch' => false,
            ],
            [
                'rolesConfig' => [
                    'sysadmin' => [
                        'children' => ['siteadmin', 'admin'],
                    ],
                    'siteadmin',
                    'admin' => [
                        'children' => ['moderator'],
                    ],
                    'moderator' => [
                        'children' => ['member'],
                    ],
                    'member' => [
                        'children' => ['guest'],
                    ],
                    'guest',
                ],
                'identityRoles' => [
                    'moderator',
                    'admin',
                ],
                'rolesToCheck' => [
                    'sysadmin',
                    'siteadmin',
                    'member',
                ],
                'doesMatch' => true,
            ],
        ];
    }

    public function testReturnGuestRoleIfNoIdentityIsGiven(): void
    {
        $identityProvider = $this->createMock(IdentityProviderInterface::class);
        $identityProvider->expects($this->once())->method('getIdentity')->willReturn(null);
        $roleService = new RoleService($identityProvider, new InMemoryRoleProvider([]), 'guest');

        $result = $roleService->getIdentityRoles(null);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals('guest', $result[0]->getName());
    }

    public function testReturnGuestRoleIfGuestIdentityIsGiven(): void
    {
        $identity = new Identity(['guest']);
        $identityProvider = $this->createMock(IdentityProviderInterface::class);
        $roleService = new RoleService($identityProvider, new InMemoryRoleProvider([]), 'guest');

        $result = $roleService->getIdentityRoles($identity);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals('guest', $result[0]->getName());
    }

    public function testReturnTraversableRolesFromIdentityGiven(): void
    {
        $identityProvider = $this->createMock(IdentityProviderInterface::class);
        $roleService = new RoleService($identityProvider, new InMemoryRoleProvider([]), 'guest');
        $identity = $this->prophesize(IdentityInterface::class);
        $identity->getRoles()->willReturn($roles = new \ArrayIterator(['first', 'second', 'third']));

        $result = $roleService->getIdentityRoles($identity->reveal());

        $this->assertCount(3, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals($roles[0], $result[0]->getName());
        $this->assertEquals($roles[1], $result[1]->getName());
        $this->assertEquals($roles[2], $result[2]->getName());
    }

    public function testWillNotInvokeRoleProviderIfAllRolesCollected(): void
    {
        $roleProvider = $this->prophesize(RoleProviderInterface::class);
        $roleProvider->getRoles(Argument::any())->shouldNotBeCalled();
        $identityProvider = $this->createMock(IdentityProviderInterface::class);

        $roleService = new RoleService($identityProvider, $roleProvider->reveal(), 'guest');
        $roles = [new Role('first'), new Role('second'), new Role('third')];
        $identity = new Identity($roles);

        $result = $roleService->getIdentityRoles($identity);

        $this->assertCount(3, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
        $this->assertEquals($roles, $result);
    }

    public function testWillCollectRolesOnlyIfRequired(): void
    {
        $roleProvider = $this->prophesize(RoleProviderInterface::class);
        $roles = [new Role('first'), new Role('second'), 'third'];
        $roleProvider->getRoles(['third'])->shouldBeCalled()->willReturn([new Role('third')]);
        $identityProvider = $this->createMock(IdentityProviderInterface::class);

        $roleService = new RoleService($identityProvider, $roleProvider->reveal(), 'guest');
        $identity = new Identity($roles);

        $result = $roleService->getIdentityRoles($identity);

        $this->assertCount(3, $result);
        $this->assertInstanceOf(RoleInterface::class, $result[0]);

        $this->assertEquals($roles[0]->getName(), $result[0]->getName());
        $this->assertEquals($roles[1]->getName(), $result[1]->getName());
        $this->assertEquals($roles[2], $result[2]->getName());
    }

    public function testGetIdentity()
    {
        $identity = new Identity([]);
        $identityProvider = $this->createMock(IdentityProviderInterface::class);
        $identityProvider->expects($this->once())->method('getIdentity')->willReturn($identity);
        $roleService = new RoleService($identityProvider, new InMemoryRoleProvider([]), 'guest');
        $this->assertEquals($identity, $roleService->getIdentity());
    }

    /**
     * @dataProvider roleProvider
     */
    public function testMatchIdentityRoles(
        array $rolesConfig,
        array $identityRoles,
        array $rolesToCheck,
        $doesMatch
    ): void {
        $identity = $this->createMock(IdentityInterface::class);
        $identity->expects($this->once())->method('getRoles')->willReturn($identityRoles);

        $identityProvider = $this->createMock(IdentityProviderInterface::class);

        $roleService = new RoleService($identityProvider, new InMemoryRoleProvider($rolesConfig), 'guest');
        $this->assertEquals($doesMatch, $roleService->matchIdentityRoles($rolesToCheck, $identity));
    }

    /**
     * @dataProvider roleProvider
     */
    public function testMatchIdentityRolesWithNullIdentity(
        array $rolesConfig,
        array $identityRoles,
        array $rolesToCheck,
        $doesMatch
    ): void {
        $identity = $this->createMock(IdentityInterface::class);
        $identity->expects($this->once())->method('getRoles')->willReturn($identityRoles);

        $identityProvider = $this->createMock(IdentityProviderInterface::class);
        $identityProvider->expects($this->once())->method('getIdentity')->willReturn($identity);
        $roleService = new RoleService($identityProvider, new InMemoryRoleProvider($rolesConfig), 'guest');
        $this->assertEquals($doesMatch, $roleService->matchIdentityRoles($rolesToCheck, null));
    }
}
