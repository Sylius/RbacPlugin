<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\Permission;

final class AdministrationRoleFactory implements AdministrationRoleFactoryInterface
{
    /** @var FactoryInterface */
    private $decoratedFactory;

    public function __construct(FactoryInterface $decoratedFactory)
    {
        $this->decoratedFactory = $decoratedFactory;
    }

    public function createWithNameAndPermissions(string $name, array $permissions): AdministrationRoleInterface
    {
        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this->decoratedFactory->createNew();

        $administrationRole->setName($name);

        /** @var string $permission */
        foreach (array_keys($permissions) as $permission) {
            $administrationRole->addPermission(Permission::ofType($permission, $permissions[$permission]));
        }

        return $administrationRole;
    }

    public function createNew(): AdministrationRoleInterface
    {
        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this->decoratedFactory->createNew();

        return $administrationRole;
    }
}
