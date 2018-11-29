<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Checker;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Checker\AdminRouteCheckerInterface;

final class HardcodedAdminRouteCheckerSpec extends ObjectBehavior
{
    function it_implements_admin_route_checker_interface(): void
    {
        $this->shouldImplement(AdminRouteCheckerInterface::class);
    }

    function it_return_true_if_passed_route_is_prefixed_with_sylius_admin(): void
    {
        $this->__invoke('sylius_admin_country_index')->shouldReturn(true);
    }

    function it_return_true_if_passed_route_is_prefixed_with_sylius_rbac_admin(): void
    {
        $this->__invoke('sylius_rbac_admin_administration_role_index')->shouldReturn(true);
    }

    function it_return_false_if_route_has_no_prefix_sylius_admin_or_sylius_rbac_admin(): void
    {
        $this->__invoke('sylius_shop_cart_summary')->shouldReturn(true);
    }
}
