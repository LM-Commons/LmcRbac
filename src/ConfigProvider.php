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

namespace ZfcRbac;

/**
 * The configuration provider for the ZfcRbac module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'zfc_rbac' => $this->getModuleConfig(),
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                \ZfcRbac\Assertion\AssertionContainerInterface::class => \ZfcRbac\Container\AssertionContainerFactory::class,
                \ZfcRbac\Options\ModuleOptions::class => \ZfcRbac\Container\ModuleOptionsFactory::class,
                \ZfcRbac\Role\InMemoryRoleProvider::class => \ZfcRbac\Container\InMemoryRoleProviderFactory::class,
                \ZfcRbac\Role\ObjectRepositoryRoleProvider::class => \ZfcRbac\Container\ObjectRepositoryRoleProviderFactory::class,
                \ZfcRbac\Service\AuthorizationServiceInterface::class => \ZfcRbac\Container\AuthorizationServiceFactory::class,
                \ZfcRbac\Service\RoleServiceInterface::class => \ZfcRbac\Container\RoleServiceFactory::class,
                \ZfcRbac\Rbac::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
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
