<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class CreateAdministrationRoleHandler
{
    /** @var ObjectManager */
    private $administrationRoleManager;

    /** @var AdministrationRoleFactoryInterface */
    private $administrationRoleFactory;

    /** @var AdministrationRoleValidatorInterface */
    private $validator;

    public function __construct(
        ObjectManager $objectManager,
        AdministrationRoleFactoryInterface $administrationRoleCreator,
        AdministrationRoleValidatorInterface $validator
    ) {
        $this->administrationRoleManager = $objectManager;
        $this->administrationRoleFactory = $administrationRoleCreator;
        $this->validator = $validator;
    }

    public function __invoke(CreateAdministrationRole $command): void
    {
        $administrationRole = $this->administrationRoleFactory->createWithNameAndPermissions(
            $command->administrationRoleName(),
            $command->permissions()
        );

        $this->validator->validate($administrationRole);

        $this->administrationRoleManager->persist($administrationRole);
        $this->administrationRoleManager->flush();
    }
}
