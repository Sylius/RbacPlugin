<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Provider;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Provider\AdminPermissionsProviderInterface;

final class AdminPermissionsProviderSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith([
            'catalog_management' => [
                'catalog_route_prefix',
            ],
            'configuration' => [
                'configuration_route_prefix',
            ],
            'customers_management' => [
                'customers_route_prefix',
            ],
            'marketing_management' => [
                'marketing_route_prefix',
            ],
            'sales_management' => [
                'sales_route_prefix',
            ],
            'custom' => [
                'custom_section' => [
                    'custom_section_route_prefix',
                ],
            ],
        ]);
    }

    function it_implements_admin_permissions_provider_interface(): void
    {
        $this->shouldImplement(AdminPermissionsProviderInterface::class);
    }

    function it_provides_hardcoded_array_of_possible_permissions(): void
    {
        $this->getPossiblePermissions()->shouldReturn([
            'catalog_management',
            'configuration',
            'custom_section',
            'customers_management',
            'marketing_management',
            'sales_management',
        ]);
    }
}
