<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Creator;

use Sylius\RbacPlugin\Access\Exception\UnresolvedRouteNameException;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;

final class AccessRequestCreator implements AccessRequestCreatorInterface
{
    /** @var array */
    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function createFromRouteName(string $routeName): AccessRequest
    {
        foreach ($this->configuration['configuration'] as $configurationRoutePrefix) {
            if (strpos($routeName, $configurationRoutePrefix) === 0) {
                return new AccessRequest(Section::configuration(), OperationType::write());
            }
        }

        foreach ($this->configuration['customers'] as $customersRoutePrefix) {
            if (strpos($routeName, $customersRoutePrefix) === 0) {
                return new AccessRequest(Section::customers(), OperationType::write());
            }
        }

        foreach ($this->configuration['marketing'] as $marketingRoutePrefix) {
            if (strpos($routeName, $marketingRoutePrefix) === 0) {
                return new AccessRequest(Section::marketing(), OperationType::write());
            }
        }

        foreach ($this->configuration['sales'] as $salesRoutePrefix) {
            if (strpos($routeName, $salesRoutePrefix) === 0) {
                return new AccessRequest(Section::sales(), OperationType::write());
            }
        }

        foreach ($this->configuration['catalog'] as $catalogRoutePrefix) {
            if (strpos($routeName, $catalogRoutePrefix) === 0) {
                return new AccessRequest(Section::catalog(), OperationType::write());
            }
        }

        throw UnresolvedRouteNameException::withRouteName($routeName);
    }
}
