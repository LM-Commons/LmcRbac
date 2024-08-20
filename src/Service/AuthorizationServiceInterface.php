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

namespace Lmc\Rbac\Service;

use Lmc\Rbac\Assertion\AssertionInterface;
use Lmc\Rbac\Identity\IdentityInterface;
use Lmc\Rbac\Permission\PermissionInterface;

/**
 * Minimal interface for an authorization service
 */
interface AuthorizationServiceInterface
{
    /**
     * Check if the permission is granted to the current identity
     */
    public function isGranted(
        ?IdentityInterface $identity,
        PermissionInterface|string $permission,
        mixed $context = null
    ): bool;

    /**
     * Set assertions, either merging or replacing (default)
     */
    public function setAssertions(array $assertions, bool $merge = false): void;

    /**
     * Set assertion for a given permission
     */
    public function setAssertion(
        PermissionInterface|string $permission,
        AssertionInterface|callable|string $assertion
    ): void;

    /**
     * Check if there are assertions for the permission
     */
    public function hasAssertion(PermissionInterface|string $permission): bool;

    /**
     * Get the assertions
     *
     * @return array
     */
    public function getAssertions(): array;

    /**
     * Get the assertions for the given permission
     */
    public function getAssertion(PermissionInterface|string $permission): AssertionInterface|callable|string|null;
}
