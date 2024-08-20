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

namespace Lmc\Rbac;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Lmc\Rbac\Assertion\AssertionPluginManager;
use Lmc\Rbac\Assertion\AssertionPluginManagerFactory;
use Lmc\Rbac\Assertion\AssertionPluginManagerInterface;
use Lmc\Rbac\Options\ModuleOptions;
use Lmc\Rbac\Options\ModuleOptionsFactory;
use Lmc\Rbac\Rbac;
use Lmc\Rbac\Role\InMemoryRoleProvider;
use Lmc\Rbac\Role\InMemoryRoleProviderFactory;
use Lmc\Rbac\Role\ObjectRepositoryRoleProvider;
use Lmc\Rbac\Role\ObjectRepositoryRoleProviderFactory;
use Lmc\Rbac\Service\AuthorizationServiceFactory;
use Lmc\Rbac\Service\AuthorizationServiceInterface;
use Lmc\Rbac\Service\RoleServiceFactory;
use Lmc\Rbac\Service\RoleServiceInterface;

/**
 * The configuration provider for the LmcRbac module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'lmc_rbac'     => $this->getModuleConfig(),
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'aliases'   => [
                AssertionPluginManagerInterface::class => AssertionPluginManager::class,
            ],
            'factories' => [
                AssertionPluginManager::class        => AssertionPluginManagerFactory::class,
                ModuleOptions::class                 => ModuleOptionsFactory::class,
                InMemoryRoleProvider::class          => InMemoryRoleProviderFactory::class,
                ObjectRepositoryRoleProvider::class  => ObjectRepositoryRoleProviderFactory::class,
                AuthorizationServiceInterface::class => AuthorizationServiceFactory::class,
                RoleServiceInterface::class          => RoleServiceFactory::class,
                Rbac::class                          => InvokableFactory::class,
            ],
        ];
    }

    public function getModuleConfig(): array
    {
        return [
            // Assertion plugin manager
            'assertion_manager' => [],
        ];
    }
}
