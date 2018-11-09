<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Model\PermissionInterface;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class UpdateAdministrationRoleHandler
{
    /** @var ObjectManager */
    private $administrationRoleManager;

    /** @var AdministrationRoleFactoryInterface */
    private $administrationRoleFactory;

    /** @var RepositoryInterface */
    private $administrationRoleRepository;

    /** @var AdministrationRoleValidatorInterface */
    private $validator;

    /** @var string */
    private $validationGroup;

    public function __construct(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        RepositoryInterface $administrationRoleRepository,
        AdministrationRoleValidatorInterface $validator,
        string $validationGroup
    ) {
        $this->administrationRoleManager = $administrationRoleManager;
        $this->administrationRoleFactory = $administrationRoleFactory;
        $this->administrationRoleRepository = $administrationRoleRepository;
        $this->validator = $validator;
        $this->validationGroup = $validationGroup;
    }

    public function __invoke(UpdateAdministrationRole $command): void
    {
        /** @var AdministrationRoleInterface|null $administrationRole */
        $administrationRole = $this
            ->administrationRoleRepository
            ->find($command->administrationRoleId())
        ;

        if (null === $administrationRole) {
            throw new \InvalidArgumentException('sylius_rbac.administration_role_does_not_exist');
        }

        $administrationRoleUpdates = $this->administrationRoleFactory->createWithNameAndPermissions(
            $command->administrationRoleName(),
            $command->permissions()
        );

        $this->validator->validate($administrationRoleUpdates, $this->validationGroup);

        $administrationRole->setName($administrationRoleUpdates->getName());
        $administrationRole->clearPermissions();

        /** @var PermissionInterface $permission */
        foreach ($administrationRoleUpdates->getPermissions() as $permission) {
            $administrationRole->addPermission($permission);
        }

        $this->administrationRoleManager->flush();
    }
}
