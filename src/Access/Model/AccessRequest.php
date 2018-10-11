<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Model;

final class AccessRequest
{
    /** @var Section */
    private $section;

    /** @var OperationType */
    private $operationType;

    public function __construct(Section $section, OperationType $operationType)
    {
        $this->section = $section;
        $this->operationType = $operationType;
    }

    public function section(): Section
    {
        return $this->section;
    }

    public function operationType(): OperationType
    {
        return $this->operationType;
    }
}
