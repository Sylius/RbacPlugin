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

    public function createFromRouteName(string $routeName, string $requestMethod): AccessRequest
    {
        $operationType = $this->resolveOperationType($requestMethod);

        foreach ($this->configuration[Section::CONFIGURATION] as $configurationRoutePrefix) {
            if (strpos($routeName, $configurationRoutePrefix) === 0) {
                return new AccessRequest(Section::configuration(), $operationType);
            }
        }

        foreach ($this->configuration[Section::CUSTOMERS] as $customersRoutePrefix) {
            if (strpos($routeName, $customersRoutePrefix) === 0) {
                return new AccessRequest(Section::customers(), $operationType);
            }
        }

        foreach ($this->configuration[Section::MARKETING] as $marketingRoutePrefix) {
            if (strpos($routeName, $marketingRoutePrefix) === 0) {
                return new AccessRequest(Section::marketing(), $operationType);
            }
        }

        foreach ($this->configuration[Section::SALES] as $salesRoutePrefix) {
            if (strpos($routeName, $salesRoutePrefix) === 0) {
                return new AccessRequest(Section::sales(), $operationType);
            }
        }

        foreach ($this->configuration[Section::CATALOG] as $catalogRoutePrefix) {
            if (strpos($routeName, $catalogRoutePrefix) === 0) {
                return new AccessRequest(Section::catalog(), $operationType);
            }
        }

        foreach ($this->configuration['custom'] as $sectionName => $sectionPrefixes) {
            foreach ($sectionPrefixes as $prefix) {
                if (strpos($routeName, $prefix) === 0) {
                    return new AccessRequest(Section::ofType($sectionName), $operationType);
                }
            }
        }

        throw UnresolvedRouteNameException::withRouteName($routeName);
    }

    public function resolveOperationType(string $requestMethod): OperationType
    {
        if ('GET' === $requestMethod || 'HEAD' === $requestMethod) {
            return OperationType::read();
        }

        return OperationType::write();
    }
}
