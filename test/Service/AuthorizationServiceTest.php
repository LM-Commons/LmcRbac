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

use Laminas\ServiceManager\ServiceManager;
use Lmc\Rbac\Assertion\AssertionPluginManager;
use Lmc\Rbac\Assertion\AssertionPluginManagerInterface;
use Lmc\Rbac\Assertion\AssertionSet;
use Lmc\Rbac\Exception\InvalidArgumentException;
use Lmc\Rbac\Identity\IdentityInterface;
use Lmc\Rbac\Identity\IdentityProviderInterface;
use Lmc\Rbac\Rbac;
use Lmc\Rbac\RbacInterface;
use Lmc\Rbac\Role\InMemoryRoleProvider;
use Lmc\Rbac\Role\Role;
use Lmc\Rbac\Role\RoleInterface;
use Lmc\Rbac\Service\AuthorizationService;
use Lmc\Rbac\Service\RoleService;
use Lmc\Rbac\Service\RoleServiceInterface;
use LmcRbacTest\Asset\Identity;
use LmcRbacTest\Asset\SimpleAssertion;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Lmc\Rbac\Service\AuthorizationService
 */
class AuthorizationServiceTest extends TestCase
{
    public static function grantedProvider(): array
    {
        return [
            // Simple is granted
            [
                'guest',
                'read',
                null,
                true,
            ],

            // Simple is allowed from parent
            [
                'member',
                'read',
                null,
                true,
            ],

            // Simple is refused
            [
                'guest',
                'write',
                null,
                false,
            ],

            // Simple is refused from parent
            [
                'guest',
                'delete',
                null,
                false,
            ],

            // Simple is refused from assertion map
            [
                'admin',
                'delete',
                false,
                false,
                [
                    'delete' => 'false_assertion',
                ],
            ],

            // Simple is accepted from assertion map
            [
                'admin',
                'delete',
                true,
                true,
                [
                    'delete' => 'true_assertion',
                ],
            ],

            // Simple is refused from no role
            [
                [],
                'read',
                null,
                false,
            ],

            // Nested is accepted from assertion map
            [
                'admin',
                'delete',
                true,
                true,
                [
                    'delete' => [
                        [
                            'false_assertion',
                            'true_assertion',
                            'condition' => AssertionSet::CONDITION_OR,
                        ],
                        'true_assertion',
                        'condition' => AssertionSet::CONDITION_AND,
                    ],
                    'sleep' => 'false_assertion',
                ],
            ],

            // If possible will not required will not execute all assertions from assertion map
            [
                'admin',
                'delete',
                true,
                true,
                [
                    'delete' => [
                        'false_assertion',
                        [
                            'false_assertion',
                            'never_executed',
                            'condition' => AssertionSet::CONDITION_AND,
                        ],
                        [
                            'true_assertion',
                            'never_executed',
                            'condition' => AssertionSet::CONDITION_OR,
                        ],
                        'never_executed',
                        'condition' => AssertionSet::CONDITION_OR,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider grantedProvider
     */
    public function testGranted($role, $permission, $context, bool $isGranted, array $assertions = []): void
    {
        $roleConfig = [
            'admin' => [
                'children' => ['member'],
                'permissions' => ['delete'],
            ],
            'member' => [
                'children' => ['guest'],
                'permissions' => ['write'],
            ],
            'guest' => [
                'permissions' => ['read'],
            ],
        ];

        $assertionPluginConfig = [
            'services' => [
                'true_assertion' => new SimpleAssertion(true),
                'false_assertion' => new SimpleAssertion(false),
            ],
        ];

        $identity = new Identity((array) $role);
        /*
        $identityProvider = $this->createMock(IdentityProviderInterface::class);

        $identityProvider->expects($this->any())
            ->method('getIdentity')
            ->willReturn($identity);
        */
        $roleService = new RoleService(new InMemoryRoleProvider($roleConfig), 'guest');
        $assertionPluginManager = new AssertionPluginManager(new ServiceManager(), $assertionPluginConfig);
        $authorizationService = new AuthorizationService(new Rbac(), $roleService, $assertionPluginManager, $assertions);

        $this->assertEquals($isGranted, $authorizationService->isGranted($identity, $permission, $context));
    }

    public function testDoNotCallAssertionIfThePermissionIsNotGranted(): void
    {
        $role = $this->getMockBuilder(RoleInterface::class)->getMock();
        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willReturn([$role]);

        $assertionPluginManager = $this->createMock(AssertionPluginManager::class);
        $assertionPluginManager->expects($this->never())->method('get');

        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager);

        $this->assertFalse($authorizationService->isGranted(null, 'foo', 'foo'));
    }

    public function testReturnsFalseForIdentityWithoutRoles(): void
    {
        $identity = new Identity();

        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();
        $rbac->expects($this->never())->method('isGranted');

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willReturn($identity->getRoles());

        $assertionPluginManager = $this->createMock(AssertionPluginManager::class);
        $assertionPluginManager->expects($this->never())->method('get');

        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager);

        $this->assertFalse($authorizationService->isGranted($identity, 'foo', 'foo'));
    }

    public function testReturnsTrueForIdentityWhenHasPermissionButNoAssertionsExists(): void
    {
        $role = new Role('admin');
        $identity = new Identity([$role]);

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willReturn($identity->getRoles());

        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();
        $rbac->expects($this->once())->method('isGranted')->willReturn(true);

        $assertionPluginManager = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionPluginManager->expects($this->never())->method('get');

        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager);

        $this->assertTrue($authorizationService->isGranted($identity, 'foo', 'foo'));
    }

    public function testUsesAssertionsAsInstances(): void
    {
        $role = new Role('admin');
        $identity = new Identity([$role]);
        $assertion = new SimpleAssertion();

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willreturn($identity->getRoles());

        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();
        $rbac->expects($this->once())->method('isGranted')->willReturn(true);

        $assertionPluginManager = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionPluginManager->expects($this->never())->method('get');

        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager, ['foo' => $assertion]);

        $authorizationService->isGranted($identity, 'foo', 'foo');

        $this->assertTrue($assertion->gotCalled());
    }

    public function testUsesAssertionsAsStrings(): void
    {
        $role = new Role('admin');
        $identity = new Identity([$role]);
        $assertion = new SimpleAssertion();

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willReturn($identity->getRoles());

        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();
        $rbac->expects($this->once())->method('isGranted')->willReturn(true);

        $assertionPluginManager = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionPluginManager->expects($this->once())->method('get')->with('fooFactory')->willReturn($assertion);

        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager, ['foo' => 'fooFactory']);

        $authorizationService->isGranted($identity, 'foo', 'foo');

        $this->assertTrue($assertion->gotCalled());
    }

    public function testUsesAssertionsAsCallable(): void
    {
        $role = new Role('admin');
        $identity = new Identity([$role]);

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willreturn($identity->getRoles());

        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();
        $rbac->expects($this->once())->method('isGranted')->willReturn(true);

        $assertionPluginManager = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionPluginManager->expects($this->never())->method('get');

        $called = false;

        $authorizationService = new AuthorizationService(
            $rbac,
            $roleService,
            $assertionPluginManager,
            [
                'foo' => function ($permission, IdentityInterface $identity = null, $context = null) use (&$called) {
                    $called = true;

                    return false;
                },
            ]
        );

        $authorizationService->isGranted($identity, 'foo', 'foo');

        $this->assertTrue($called);
    }

    public function testUsesAssertionsAsArrays(): void
    {
        $role = new Role('admin');
        $identity = new Identity([$role]);

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willreturn($identity->getRoles());

        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();
        $rbac->expects($this->once())->method('isGranted')->willReturn(true);

        $assertionPluginManager = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionPluginManager->expects($this->never())->method('get');

        $called1 = false;
        $called2 = false;

        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager, [
            'foo' => [
                function ($permission, IdentityInterface $identity = null, $context = null) use (&$called1) {
                    $called1 = true;

                    return true;
                },
                function ($permission, IdentityInterface $identity = null, $context = null) use (&$called2) {
                    $called2 = true;

                    return false;
                },
            ],
        ]);

        $this->assertFalse($authorizationService->isGranted($identity, 'foo', 'foo'));

        $this->assertTrue($called1);
        $this->assertTrue($called2);
    }

    public function testThrowExceptionForInvalidAssertion(): void
    {
        $role = $this->getMockBuilder(RoleInterface::class)->getMock();
        $rbac = $this->getMockBuilder(Rbac::class)->disableOriginalConstructor()->getMock();

        $rbac->expects($this->once())->method('isGranted')->willReturn(true);

        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $roleService->expects($this->once())->method('getIdentityRoles')->willreturn([$role]);

        $assertionPluginManager = $this->getMockBuilder(AssertionPluginManagerInterface::class)->disableOriginalConstructor()->getMock();
        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager, ['foo' => new \stdClass()]);

        $this->expectException(InvalidArgumentException::class);

        $authorizationService->isGranted(new Identity(), 'foo', 'foo');
    }

    public function testContextIsPassedToRoleService(): void
    {
        $identity = new Identity([]);
        $context = 'context';

        $rbac = $this->getMockBuilder(RbacInterface::class)->disableOriginalConstructor()->getMock();
        $roleService = $this->getMockBuilder(RoleServiceInterface::class)->getMock();
        $assertionPluginManager = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $authorizationService = new AuthorizationService($rbac, $roleService, $assertionPluginManager);

        $roleService->expects($this->once())->method('getIdentityRoles')->with($identity, $context)->willReturn([]);
        $authorizationService->isGranted($identity, 'foo', $context);
    }
}
