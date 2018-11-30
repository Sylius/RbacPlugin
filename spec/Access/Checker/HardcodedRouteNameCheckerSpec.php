<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Checker;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Checker\RouteNameCheckerInterface;

final class HardcodedRouteNameCheckerSpec extends ObjectBehavior
{
    function it_implements_admin_route_checker_interface(): void
    {
        $this->shouldImplement(RouteNameCheckerInterface::class);
    }

    function it_returns_true_if_passed_route_is_prefixed_with_sylius_admin(): void
    {
        $this->isAdminRoute('sylius_admin_country_index')->shouldReturn(true);
    }

    function it_returns_true_if_passed_route_is_prefixed_with_sylius_rbac_admin(): void
    {
        $this->isAdminRoute('sylius_rbac_admin_administration_role_index')->shouldReturn(true);
    }

    function it_returns_false_if_route_has_no_prefix_sylius_admin_or_sylius_rbac_admin(): void
    {
        $this->isAdminRoute('sylius_shop_cart_summary')->shouldReturn(false);
    }
}
