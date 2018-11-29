<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

final class AdminPermissionsProvider implements AdminPermissionsProviderInterface
{
    /** @var array */
    private $rbacConfiguration;

    public function __construct(array $rbacConfiguration)
    {
        foreach ($rbacConfiguration['custom'] as $customSection => $customRoutes) {
            $rbacConfiguration[$customSection] = $customRoutes;
        }

        unset($rbacConfiguration['custom']);

        $this->rbacConfiguration = array_keys($rbacConfiguration);
    }

    /** @return array|string[] */
    public function getPossiblePermissions(): array
    {
        return $this->rbacConfiguration;
    }
}
