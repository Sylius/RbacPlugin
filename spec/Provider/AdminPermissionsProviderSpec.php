<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Provider;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Provider\AdminPermissionsProviderInterface;

final class AdminPermissionsProviderSpec extends ObjectBehavior
{
    function it_implements_admin_permissions_provider_interface(): void
    {
        $this->shouldImplement(AdminPermissionsProviderInterface::class);
    }

    function it_provides_hardcoded_array_of_possible_permissions(): void
    {
        $this->getPossiblePermissions()->shouldReturn([
            'catalog_management',
            'configuration',
            'customers_management',
            'marketing_management',
            'sales_management',
        ]);
    }
}
