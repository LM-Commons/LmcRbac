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

namespace LmcRbacTest\Options;

use Lmc\Rbac\Options\ModuleOptions;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass('\Lmc\Rbac\Options\ModuleOptions')]
class ModuleOptionsTest extends TestCase
{
    public function testAssertModuleDefaultOptions(): void
    {
        $moduleOptions = new \Lmc\Rbac\Options\ModuleOptions();

        $this->assertEquals('guest', $moduleOptions->getGuestRole());
        $this->assertIsArray($moduleOptions->getRoleProvider());
        $this->assertIsArray($moduleOptions->getAssertionMap());
        $this->assertEquals('Lmc\Rbac\Role\InMemoryRoleProvider', key($moduleOptions->getRoleProvider()));
        $this->assertEquals('Lmc\Rbac\Identity\AuthenticationIdentityProvider', $moduleOptions->getIdentityProvider());
    }

    public function testSettersAndGetters(): void
    {
        $moduleOptions = new ModuleOptions([
            'guest_role' => 'unknown',
            'role_provider' => [],
            'assertion_map' => [
                'foo' => 'bar',
            ],
            'identity_provider' => 'foo',
        ]);

        $this->assertEquals('unknown', $moduleOptions->getGuestRole());
        $this->assertEquals([], $moduleOptions->getRoleProvider());
        $this->assertEquals(['foo' => 'bar'], $moduleOptions->getAssertionMap());
        $this->assertEquals('foo', $moduleOptions->getIdentityProvider());
    }
}
