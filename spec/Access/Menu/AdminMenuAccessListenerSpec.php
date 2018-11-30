<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Menu;

use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\Section;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class AdminMenuAccessListenerSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $tokenStorage, AdministratorAccessCheckerInterface $accessChecker): void
    {
        $this->beConstructedWith($tokenStorage, $accessChecker, [
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

    function it_removes_sections_both_basic_and_custom_to_which_current_admin_does_not_have_access(
        TokenStorageInterface $tokenStorage,
        AdministratorAccessCheckerInterface $accessChecker,
        TokenInterface $token,
        AdminUserInterface $adminUser,
        MenuBuilderEvent $event,
        ItemInterface $menu
    ): void {
        $event->getMenu()->willReturn($menu);

        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($adminUser);

        $accessChecker->canAccessSection($adminUser, Argument::that(function (AccessRequest $accessRequest): bool {
            return $accessRequest->section() == Section::catalog();
        }))->willReturn(false);

        $accessChecker->canAccessSection($adminUser, Argument::that(function (AccessRequest $accessRequest): bool {
            return $accessRequest->section() == Section::configuration();
        }))->willReturn(true);

        $accessChecker->canAccessSection($adminUser, Argument::that(function (AccessRequest $accessRequest): bool {
            return $accessRequest->section() == Section::customers();
        }))->willReturn(true);

        $accessChecker->canAccessSection($adminUser, Argument::that(function (AccessRequest $accessRequest): bool {
            return $accessRequest->section() == Section::marketing();
        }))->willReturn(false);

        $accessChecker->canAccessSection($adminUser, Argument::that(function (AccessRequest $accessRequest): bool {
            return $accessRequest->section() == Section::sales();
        }))->willReturn(false);

        $accessChecker->canAccessSection($adminUser, Argument::that(function (AccessRequest $accessRequest): bool {
            return $accessRequest->section() == Section::ofType('custom_section');
        }))->willReturn(false);

        $menu->removeChild('catalog')->shouldBeCalled();
        $menu->removeChild('configuration')->shouldNotBeCalled();
        $menu->removeChild('customers')->shouldNotBeCalled();
        $menu->removeChild('marketing')->shouldBeCalled();
        $menu->removeChild('sales')->shouldBeCalled();
        $menu->removeChild('custom_section')->shouldBeCalled();

        $this->removeInaccessibleAdminMenuParts($event);
    }

    function it_throws_exception_if_there_is_no_logged_in_user(
        TokenStorageInterface $tokenStorage,
        MenuBuilderEvent $event
    ): void {
        $tokenStorage->getToken()->willReturn(null);

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('removeInaccessibleAdminMenuParts', [$event])
        ;
    }

    function it_throws_exception_if_logged_in_user_is_not_administrator(
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        ShopUserInterface $shopUser,
        MenuBuilderEvent $event
    ): void {
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($shopUser);

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('removeInaccessibleAdminMenuParts', [$event])
        ;
    }
}
