<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Validator;

use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AdministrationRoleValidator implements AdministrationRoleValidatorInterface
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(AdministrationRoleInterface $administrationRole, string $validationGroup): void
    {
        /** @var ConstraintViolationListInterface $constraintViolations */
        $constraintViolations = $this->validator->validate($administrationRole, null, $validationGroup);

        if ($constraintViolations->count() > 0) {
            throw new \InvalidArgumentException($constraintViolations->get(0)->getMessage());
        }
    }
}
