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

namespace LmcRbacTest\Role;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Lmc\Rbac\Role\ObjectRepositoryRoleProvider;
use Lmc\Rbac\Role\Role;
use Lmc\Rbac\Role\RoleInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Lmc\Rbac\Role\ObjectRepositoryRoleProvider
 */
class ObjectRepositoryRoleProviderTest extends TestCase
{

    public static function roleProvider(): array
    {
        return [
            'one-role-flat' => [
                'rolesConfig' => [
                    'admin',
                ],
                'rolesToCheck' => ['admin'],
            ],
            '2-roles-flat' => [
                'rolesConfig' => [
                    'admin',
                    'member',
                ],
                'rolesToCheck' => ['admin', 'member'],
            ],
        ];
    }

    public function testObjectRepositoryProviderGetRoles(): void
    {
        $objectRepository = $this->createMock(ObjectRepository::class);
        $memberRole = new Role('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        $objectRepository->expects($this->once())->method('findBy')->willReturn($result);

        $this->assertEquals($result, $provider->getRoles(['member']));
    }

    public function testRoleCacheOnConsecutiveCalls(): void
    {
        $objectRepository = $this->createMock(ObjectRepository::class);
        $memberRole = new Role('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        // note exactly once, consecutive call come from cache
        $objectRepository->expects($this->exactly(1))->method('findBy')->willReturn($result);

        $provider->getRoles(['member']);
        $provider->getRoles(['member']);
    }

    public function testClearRoleCache(): void
    {
        $objectRepository = $this->createMock(ObjectRepository::class);
        $memberRole = new Role('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        // note exactly twice, as cache is cleared
        $objectRepository->expects($this->exactly(2))->method('findBy')->willReturn($result);

        $provider->getRoles(['member']);
        $provider->clearRoleCache();
        $provider->getRoles(['member']);
    }

    public function testThrowExceptionIfAskedRoleIsNotFound(): void
    {
        $objectRepository = $this->createMock(ObjectRepository::class);
        $memberRole = new Role('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        $objectRepository->expects($this->once())->method('findBy')->willReturn($result);

        $this->expectException('Lmc\Rbac\Exception\RoleNotFoundException');
        $this->expectExceptionMessage('Some roles were asked but could not be loaded from database: guest, admin');

        $provider->getRoles(['guest', 'admin', 'member']);
    }

    /**
     * @dataProvider roleProvider
     */
    public function testObjectRepositoryProviderForFlatRole(array $rolesConfig, array $rolesToCheck)
    {
        $objectManager = $this->getObjectManager();
        foreach ($rolesConfig as $name => $roleConfig) {
            if (is_array($roleConfig)) {
                $role = new \LmcRbacTest\Asset\Role($name);
                if (isset($roleConfig['permissions'])) {
                    foreach ($roleConfig['permissions'] as $permission) {
                        $role->addPermission($permission);
                    }
                }
            } else {
                $role = new \LmcRbacTest\Asset\Role($roleConfig);
            }
            $objectManager->persist($role);
        }
        $objectManager->flush();

        $objectRepository = $objectManager->getRepository('LmcRbacTest\Asset\Role');
        $objectRepositoryRoleProvider = new ObjectRepositoryRoleProvider($objectRepository, 'name');

        $roles = $objectRepositoryRoleProvider->getRoles($rolesToCheck);

        $this->assertIsArray($roles);
        $this->assertCount(count($rolesToCheck), $roles);

        $i = 0;
        foreach ($roles as $role) {
            $this->assertInstanceOf(RoleInterface::class, $role);
            $this->assertEquals($rolesToCheck[$i], $role->getName());
            $i++;
        }
    }

    public function testObjectRepositoryProviderForFlatRoleWithPermissions()
    {
        $objectManager = $this->getObjectManager();

        // Let's create a role
        $adminRole = new \LmcRbacTest\Asset\Role('admin');
        $adminRole->addPermission('manage');
        $adminRole->addPermission('write');
        $adminRole->addPermission('read');
        $objectManager->persist($adminRole);
        $objectManager->flush();

        $objectRepository = $objectManager->getRepository('LmcRbacTest\Asset\Role');

        $objectRepositoryRoleProvider = new ObjectRepositoryRoleProvider($objectRepository, 'name');

        // Get only the role
        $roles = $objectRepositoryRoleProvider->getRoles(['admin']);

        $this->assertCount(1, $roles);
        $this->assertIsArray($roles);

        $this->assertInstanceOf('Lmc\Rbac\Role\RoleInterface', $roles[0]);
        $this->assertEquals('admin', $roles[0]->getName());
        $this->assertTrue($roles[0]->hasPermission('manage'));
        $this->assertTrue($roles[0]->hasPermission('read'));
        $this->assertTrue($roles[0]->hasPermission('write'));
        $this->assertFalse($roles[0]->hasPermission('foo'));
    }

    public function testObjectRepositoryProviderForHierarchicalRole()
    {
        $objectManager = $this->getObjectManager();

        // Let's add some roles
        $guestRole = new \LmcRbacTest\Asset\Role('guest');
        $objectManager->persist($guestRole);

        $memberRole = new \LmcRbacTest\Asset\Role('member');
        $memberRole->addChild($guestRole);
        $objectManager->persist($memberRole);

        $adminRole = new \LmcRbacTest\Asset\Role('admin');
        $adminRole->addChild($memberRole);
        $objectManager->persist($adminRole);

        $objectManager->flush();

        $objectRepository = $objectManager->getRepository('LmcRbacTest\Asset\Role');

        $objectRepositoryRoleProvider = new ObjectRepositoryRoleProvider($objectRepository, 'name');

        // Get only the admin role
        $roles = $objectRepositoryRoleProvider->getRoles(['admin']);

        $this->assertCount(1, $roles);
        $this->assertIsArray($roles);

        $this->assertInstanceOf('Lmc\Rbac\Role\RoleInterface', $roles[0]);
        $this->assertEquals('admin', $roles[0]->getName());

        $childRolesString = '';

        foreach ($this->flattenRoles($roles[0]->getChildren()) as $childRole) {
            $this->assertInstanceOf('Lmc\Rbac\Role\RoleInterface', $childRole);
            $childRolesString .= $childRole->getName();
        }

        $this->assertEquals('memberguest', $childRolesString);
    }

    private function getObjectManager(): ObjectManager|EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/../Asset'],
            isDevMode: true
        );
        $connection = DriverManager::getConnection([
            'driverClass' => 'Doctrine\DBAL\Driver\PDO\SQLite\Driver',
            'path' => null,
            'memory' => true,
            'dbname' => 'test',
        ], $config);
        $entityManager = new EntityManager($connection, $config);

        $schemaTool = new SchemaTool($objectManager = $entityManager);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema($entityManager->getMetadataFactory()->getAllMetadata());

        return $objectManager;
    }

    private function flattenRoles(iterable $roles): \Generator
    {
        foreach ($roles as $role) {
            yield $role;

            if ($role->hasChildren()) {
                yield from $this->flattenRoles($role->getChildren());
            }
        }
    }
}
