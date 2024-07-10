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

use LmcRbac\Role\Role;
use LmcRbac\Role\RoleInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LmcRbac\Role\Role
 * @group Coverage
 */
class RoleTest extends TestCase
{
    public function testSetNameByConstructor(): void
    {
        $role = new Role('phpIsHell');
        $this->assertEquals('phpIsHell', $role->getName());
    }

    /**
     * @covers \LmcRbac\Role\Role::addPermission
     */
    public function testRoleCanAddPermission(): void
    {
        $role = new Role('php');

        $role->addPermission('debug');
        $this->assertTrue($role->hasPermission('debug'));

        $role->addPermission('delete');

        $this->assertTrue($role->hasPermission('delete'));
    }

    /**
     * @covers \LmcRbac\Role\Role::getPermissions
     */
    public function testRoleCanGetPermissions(): void
    {
        $role = new Role('php');

        $role->addPermission('foo');
        $role->addPermission('bar');

        $expectedPermissions = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];
        $this->assertEquals($expectedPermissions, $role->getPermissions());
    }

    /**
     * @covers \LmcRbac\Role\Role::hasPermission
     */
    public function testHasPermission(): void
    {
        $role = new Role('php');
        $role->addPermission('foo');
        $this->assertTrue($role->hasPermission('foo'));
        $this->assertFalse($role->hasPermission('bar'));

        $childRole = new Role('child');
        $childRole->addPermission('bar');
        $role->addChild($childRole);
        $this->assertTrue($role->hasPermission('bar'));
        $this->assertFalse($role->hasPermission('baz'));

    }

    /**
     * @covers \LmcRbac\Role\Role::addChild
     */
    public function testCanAddChild(): void
    {
        $role = new Role('role');
        $child = new Role('child');

        $role->addChild($child);

        $this->assertCount(1, $role->getChildren());
    }

    /**
     * @covers \LmcRbac\Role\Role::hasChildren
     */
    public function testHasChildren(): void
    {
        $role = new Role('role');

        $this->assertFalse($role->hasChildren());

        $role->addChild(new Role('child'));

        $this->assertTrue($role->hasChildren());
    }

    /**
     * @covers \LmcRbac\Role\Role::getChildren
     */
    public function testCanGetChildren(): void
    {
        $role = new Role('role');
        $child1 = new Role('child 1');
        $child2 = new Role('child 2');

        $role->addChild($child1);
        $role->addChild($child2);

        $children = $role->getChildren();

        $this->assertCount(2, $children);
        $this->assertContainsOnlyInstancesOf(RoleInterface::class, $children);
    }
}
