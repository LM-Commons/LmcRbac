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

use Lmc\Rbac\Exception\ServiceNotCreatedException;
use Lmc\Rbac\Service\AuthorizationServiceDelegatorFactory;
use Lmc\Rbac\Service\AuthorizationServiceInterface;
use LmcTest\Rbac\Asset\DummyAuthorizationServiceClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use stdClass;

#[CoversClass(AuthorizationServiceDelegatorFactory::class)]
final class AuthorizationServiceDelegatorFactoryTest extends TestCase
{
    public function testDelegatorFactory(): void
    {
        $authorizationService = $this->createStub(AuthorizationServiceInterface::class);
        $container            = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())->method('get')->willReturn($authorizationService);
        $callback         = function (): DummyAuthorizationServiceClass {
            return new DummyAuthorizationServiceClass();
        };
        $delegatorFactory = new AuthorizationServiceDelegatorFactory();
        $delegatorFactory($container, DummyAuthorizationServiceClass::class, $callback);
    }

    public function testDelegatorFactoryException(): void
    {
        $authorizationService = $this->createStub(AuthorizationServiceInterface::class);
        $container            = $this->createMock(ContainerInterface::class);
        $callback             = function (): stdClass {
            return new stdClass();
        };
        $delegatorFactory     = new AuthorizationServiceDelegatorFactory();
        $container->expects($this->never())->method('get')->willReturn($authorizationService);
        $this->expectException(ServiceNotCreatedException::class);
        $delegatorFactory($container, DummyAuthorizationServiceClass::class, $callback);
    }
}
