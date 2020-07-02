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

use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use LmcRbac\Role\ObjectRepositoryRoleProvider;
use LmcRbacTest\Asset\FlatRole;

/**
 * @covers \LmcRbac\Role\ObjectRepositoryRoleProvider
 */
class ObjectRepositoryRoleProviderTest extends TestCase
{
    public function testObjectRepositoryProviderGetRoles(): void
    {
        $objectRepository = $this->getMockBuilder(ObjectRepository::class)->getMock();
        $memberRole = new FlatRole('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        $objectRepository->expects($this->once())->method('findBy')->will($this->returnValue($result));

        $this->assertEquals($result, $provider->getRoles(['member']));
    }

    public function testRoleCacheOnConsecutiveCalls(): void
    {
        $objectRepository = $this->getMockBuilder(ObjectRepository::class)->getMock();
        $memberRole = new FlatRole('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        // note exactly once, consecutive call come from cache
        $objectRepository->expects($this->exactly(1))->method('findBy')->will($this->returnValue($result));

        $provider->getRoles(['member']);
        $provider->getRoles(['member']);
    }

    public function testClearRoleCache(): void
    {
        $objectRepository = $this->getMockBuilder(ObjectRepository::class)->getMock();
        $memberRole = new FlatRole('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        // note exactly twice, as cache is cleared
        $objectRepository->expects($this->exactly(2))->method('findBy')->will($this->returnValue($result));

        $provider->getRoles(['member']);
        $provider->clearRoleCache();
        $provider->getRoles(['member']);
    }

    public function testThrowExceptionIfAskedRoleIsNotFound(): void
    {
        $objectRepository = $this->getMockBuilder(ObjectRepository::class)->getMock();
        $memberRole = new FlatRole('member');
        $provider = new ObjectRepositoryRoleProvider($objectRepository, 'name');
        $result = [$memberRole];

        $objectRepository->expects($this->once())->method('findBy')->will($this->returnValue($result));

        $this->expectException('LmcRbac\Exception\RoleNotFoundException');
        $this->expectExceptionMessage('Some roles were asked but could not be loaded from database: guest, admin');

        $provider->getRoles(['guest', 'admin', 'member']);
    }
}
