<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Validator;

use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;

interface AdministrationRoleValidatorInterface
{
    public function validate(AdministrationRoleInterface $administrationRole, string $validationGroup): void;
}
