<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Creator\AdministrationRoleCreatorInterface;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class CreateAdministrationRoleHandler
{
    /** @var ObjectManager */
    private $administrationRoleManager;

    /** @var AdministrationRoleCreatorInterface */
    private $administrationRoleCreator;

    /** @var AdministrationRoleValidatorInterface */
    private $validator;

    public function __construct(
        ObjectManager $objectManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        AdministrationRoleValidatorInterface $validator
    ) {
        $this->administrationRoleManager = $objectManager;
        $this->administrationRoleCreator = $administrationRoleCreator;
        $this->validator = $validator;
    }

    public function __invoke(CreateAdministrationRole $command): void
    {
        $administrationRole = $this->administrationRoleCreator->create(
            $command->administrationRoleName(),
            $command->permissions()
        );

        $this->validator->validate($administrationRole);

        $this->administrationRoleManager->persist($administrationRole);
        $this->administrationRoleManager->flush();
    }
}
