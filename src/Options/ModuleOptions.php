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

namespace LmcRbac\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Options for LmcRbac module
 *
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Key of the identity provider used to retrieve the identity
     */
    protected string $identityProvider = 'LmcRbac\Identity\AuthenticationIdentityProvider';

    /**
     * Guest role (used when no identity is found)
     *
     * @var string
     */
    protected string $guestRole = 'guest';

    /**
     * Assertion map
     *
     * @var array
     */
    protected array $assertionMap = [];

    /**
     * A configuration for role provider
     * Defaults to InMemoryRoleProvider
     *
     * @var array
     */
    protected array $roleProvider = [
        'LmcRbac\Role\InMemoryRoleProvider' => [],
    ];

    /**
     * Constructor
     *
     * {@inheritdoc}
     */
    public function __construct($options = null)
    {
        $this->__strictMode__ = false;

        parent::__construct($options);
    }

    /**
     * Set the key of the identity provider used to retrieve the identity
     *
     * @param string $identityProvider
     * @return void
     */
    public function setIdentityProvider(string $identityProvider): void
    {
        $this->identityProvider = $identityProvider;
    }

    /**
     * Get the key of the identity provider used to retrieve the identity
     *
     * @return string
     */
    public function getIdentityProvider(): string
    {
        return $this->identityProvider;
    }

    /**
     * Set the assertions options
     *
     * @param array $assertionMap
     * @return void
     */
    public function setAssertionMap(array $assertionMap): void
    {
        $this->assertionMap = $assertionMap;
    }

    /**
     * Get the assertions options
     *
     * @return array
     */
    public function getAssertionMap(): array
    {
        return $this->assertionMap;
    }

    /**
     * Set the guest role (used when no identity is found)
     *
     * @param string $guestRole
     * @return void
     */
    public function setGuestRole(string $guestRole): void
    {
        $this->guestRole = $guestRole;
    }

    /**
     * Get the guest role (used when no identity is found)
     *
     * @return string
     */
    public function getGuestRole(): string
    {
        return $this->guestRole;
    }

    /**
     * Set the configuration for the role provider
     *
     * @param array $roleProvider
     */
    public function setRoleProvider(array $roleProvider): void
    {
        $this->roleProvider = $roleProvider;
    }

    public function getRoleProvider(): array
    {
        return $this->roleProvider;
    }
}
