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

namespace LmcRbacTest\Asset;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LmcRbac\Role\HierarchicalRoleInterface;
use LmcRbac\Role\RoleInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="hierarchical_roles")
 */
class HierarchicalRole implements HierarchicalRoleInterface
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=32, unique=true)
     */
    protected $name;

    /**
     * @var RoleInterface[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="HierarchicalRole")
     */
    protected $children;

    /**
     * @var string[]
     *
     * @ORM\ManyToMany(targetEntity="Permission", indexBy="name", fetch="EAGER")
     */
    protected $permissions;

    /**
     * Init the Doctrine collection
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->permissions = new ArrayCollection();
    }

    /**
     * Get the role identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function hasChildren(): bool
    {
        return ! empty($this->children);
    }

    public function getChildren(): iterable
    {
        return $this->children;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasPermission(string $permission): bool
    {
    }

    public function addChild(RoleInterface $child): void
    {
        $this->children[$child->getName()] = $child;
    }
}
