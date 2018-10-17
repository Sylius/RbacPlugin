<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Creator\AdministrationRoleCreatorInterface;

final class CreateAdministrationRoleHandler
{
    /** @var ObjectManager */
    private $administrationRoleManager;

    /** @var AdministrationRoleCreatorInterface */
    private $administrationRoleCreator;

    public function __construct(
        ObjectManager $objectManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator
    ) {
      $this->administrationRoleManager = $objectManager;
      $this->administrationRoleCreator = $administrationRoleCreator;
    }

    public function __invoke(CreateAdministrationRole $command)
    {
        $administrationRole = $this->administrationRoleCreator->create(
            $command->administrationRoleName(),
            $command->permissions()
        );

        $this->administrationRoleManager->persist($administrationRole);
        $this->administrationRoleManager->flush();
    }
}
