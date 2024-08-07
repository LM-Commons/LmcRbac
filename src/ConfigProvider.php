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

use Lmc\Rbac\Assertion\AssertionPluginManager;
use Lmc\Rbac\Identity\AuthenticationIdentityProvider;

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
            'lmc_rbac' => $this->getModuleConfig(),
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                \Lmc\Rbac\Assertion\AssertionPluginManager::class => \Lmc\Rbac\Assertion\AssertionPluginManagerFactory::class,
                \Lmc\Rbac\Options\ModuleOptions::class => \Lmc\Rbac\Options\ModuleOptionsFactory::class,
                \Lmc\Rbac\Role\InMemoryRoleProvider::class => \Lmc\Rbac\Role\InMemoryRoleProviderFactory::class,
                \Lmc\Rbac\Role\ObjectRepositoryRoleProvider::class => \Lmc\Rbac\Role\ObjectRepositoryRoleProviderFactory::class,
                \Lmc\Rbac\Service\AuthorizationServiceInterface::class => \Lmc\Rbac\Service\AuthorizationServiceFactory::class,
                \Lmc\Rbac\Service\RoleServiceInterface::class => \Lmc\Rbac\Service\RoleServiceFactory::class,
                \Lmc\Rbac\Rbac::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
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
