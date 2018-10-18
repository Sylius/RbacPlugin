<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Creator\AdministrationRoleCreatorInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;

final class UpdateAdministrationRoleHandler
{
    /** @var ObjectManager */
    private $administrationRoleManager;

    /** @var AdministrationRoleCreatorInterface */
    private $administrationRoleCreator;

    /** @var RepositoryInterface */
    private $administrationRoleRepository;

    public function __construct(
        ObjectManager $administrationRoleManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        RepositoryInterface $administrationRoleRepository
    ) {
        $this->administrationRoleManager = $administrationRoleManager;
        $this->administrationRoleCreator = $administrationRoleCreator;
        $this->administrationRoleRepository = $administrationRoleRepository;
    }

    public function __invoke(UpdateAdministrationRole $command): void
    {
        $administrationRoleUpdates = $this->administrationRoleCreator->create(
            $command->administrationRoleName(),
            $command->permissions()
        );

        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this
            ->administrationRoleRepository
            ->find($command->administrationRoleId())
        ;

        $administrationRole->setName($administrationRoleUpdates->getName());

        foreach ($administrationRole->getPermissions() as $permission) {
            $administrationRole->removePermission($permission);
        }

        foreach ($administrationRoleUpdates->getPermissions() as $permission) {
            $administrationRole->addPermission($permission);
        }

        $this->administrationRoleManager->persist($administrationRole);
        $this->administrationRoleManager->flush();
    }
}
