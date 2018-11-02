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

    public function validate(AdministrationRoleInterface $administrationRole): void
    {
        /** @var ConstraintViolationListInterface $constraintViolations */
        $constraintViolations = $this->validator->validate($administrationRole, null, 'sylius');

        if ($constraintViolations->count() > 0) {
            throw new \InvalidArgumentException($constraintViolations->get(0)->getMessage());
        }
    }
}
