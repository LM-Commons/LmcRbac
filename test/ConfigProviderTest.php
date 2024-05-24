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

namespace LmcRbacTest;

use LmcRbac\ConfigProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \LmcRbac\ConfigProvider
 */
class ConfigProviderTest extends TestCase
{
    public function testProvidesExpectedConfiguration()
    {
        $provider = new ConfigProvider();
        $expected = [
            'factories' => [
                \LmcRbac\Assertion\AssertionContainerInterface::class => \LmcRbac\Assertion\AssertionContainerFactory::class,
                \LmcRbac\Options\ModuleOptions::class => \LmcRbac\Options\ModuleOptionsFactory::class,
                \LmcRbac\Role\InMemoryRoleProvider::class => \LmcRbac\Role\InMemoryRoleProviderFactory::class,
                \LmcRbac\Role\ObjectRepositoryRoleProvider::class => \LmcRbac\Role\ObjectRepositoryRoleProviderFactory::class,
                \LmcRbac\Service\AuthorizationServiceInterface::class => \LmcRbac\Service\AuthorizationServiceFactory::class,
                \LmcRbac\Service\RoleServiceInterface::class => \LmcRbac\Service\RoleServiceFactory::class,
                \LmcRbac\Rbac::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
            ],
        ];
        $this->assertEquals($expected, $provider->getDependencyConfig());
    }

    public function testProvidesExpectedModuleConfiguration()
    {
        $provider = new ConfigProvider();
        $expected = [
            'assertion_manager' => [],
        ];
        $this->assertEquals($expected, $provider->getModuleConfig());
    }

    public function testInvocationProvidesDependencyConfiguration()
    {
        $provider = new ConfigProvider();
        $expected = [
            'dependencies' => $provider->getDependencyConfig(),
            'lmc_rbac' => $provider->getModuleConfig(),
        ];
        $this->assertEquals($expected, $provider());
    }
}
