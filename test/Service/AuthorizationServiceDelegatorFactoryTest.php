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

namespace LmcRbacTest\Service;

/**
 * @author Eric Richer <eric.richer@vistoconsulting.com>
 */

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Lmc\Rbac\Service\AuthorizationServiceDelegatorFactory;
use Lmc\Rbac\Service\AuthorizationServiceInterface;
use LmcRbacTest\Asset\DummyAuthorizationServiceClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;

#[CoversClass('\Lmc\Rbac\Service\AuthorizationServiceDelegatorFactory')]
class AuthorizationServiceDelegatorFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testDelegatorFactory(): void
    {
        $authorizationService = $this->createMock(AuthorizationServiceInterface::class);
        $container = $this->prophesize(ContainerInterface::class);

        $callback = function () {
            return new DummyAuthorizationServiceClass();
        };

        $container->get(AuthorizationServiceInterface::class)->willReturn($authorizationService)->shouldBeCalled();

        $delegatorFactory = new AuthorizationServiceDelegatorFactory();
        $instance = $delegatorFactory($container->reveal(), DummyAuthorizationServiceClass::class, $callback );
        $this->assertInstanceOf(DummyAuthorizationServiceClass::class, $instance);
    }

    public function testDelegatorFactoryException(): void
    {
        $authorizationService = $this->createMock(AuthorizationServiceInterface::class);
        $container = $this->prophesize(ContainerInterface::class);

        $callback = function () {
            return new \StdClass();
        };
        $delegatorFactory = new AuthorizationServiceDelegatorFactory();

        $container->get(AuthorizationServiceInterface::class)->willReturn($authorizationService)->shouldNotBeCalled();
        $this->expectException(ServiceNotCreatedException::class);

        $instance = $delegatorFactory($container->reveal(), DummyAuthorizationServiceClass::class, $callback );
    }
}
