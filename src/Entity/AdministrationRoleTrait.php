<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

trait AdministrationRoleTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="Sylius\RbacPlugin\Entity\AdministrationRole")
     * @ORM\JoinColumn(name="administration_role_id", referencedColumnName="id")
     * @var AdministrationRoleInterface|null
     */
    private $administrationRole;

    public function setAdministrationRole(?AdministrationRoleInterface $administrationRole): void
    {
        $this->administrationRole = $administrationRole;
    }

    public function getAdministrationRole(): ?AdministrationRoleInterface
    {
        return $this->administrationRole;
    }
}
