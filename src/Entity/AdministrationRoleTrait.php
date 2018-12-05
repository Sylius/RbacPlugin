<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

trait AdministrationRoleTrait
{
    /**
     * @ManyToOne(targetEntity="Sylius\RbacPlugin\Entity\AdministrationRole")
     * @JoinColumn(name="administrationRole_id", referencedColumnName="id")
     *
     * @var AdministrationRoleInterface|null
     */
    private $administrationRole;

    public function getAdministrationRole(): ?AdministrationRoleInterface
    {
        return $this->administrationRole;
    }

    public function setAdministrationRole(?AdministrationRoleInterface $administrationRole): void
    {
        $this->administrationRole = $administrationRole;
    }
}
