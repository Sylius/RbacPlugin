<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Creator\AccessRequestCreatorInterface;
use Sylius\RbacPlugin\Access\Exception\UnresolvedRouteNameException;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class AccessCheckListenerSpec extends ObjectBehavior
{
    function let(
        AccessRequestCreatorInterface $accessRequestCreator,
        AdministratorAccessCheckerInterface $administratorAccessChecker,
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $router
    ): void {
        $this->beConstructedWith($accessRequestCreator, $administratorAccessChecker, $tokenStorage, $router);
    }

    function it_redirects_to_admin_dashboard_if_admin_does_not_have_access_to_target_route(
        AccessRequestCreatorInterface $accessRequestCreator,
        AdministratorAccessCheckerInterface $administratorAccessChecker,
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $router,
        GetResponseEvent $event,
        Request $request,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $event->getRequest()->willReturn($request);
        $request->attributes = new ParameterBag(['_route' => 'sylius_admin_some_route']);

        $accessRequest = new AccessRequest(Section::catalog(), OperationType::write());
        $accessRequestCreator->createFromRouteName('sylius_admin_some_route')->willReturn($accessRequest);

        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($adminUser);

        $administratorAccessChecker->hasAccessToSection($adminUser, $accessRequest)->willReturn(false);
        $router->generate('sylius_admin_dashboard')->willReturn('http://sylius.dev/admin/');

        $event->setResponse(Argument::that(function (RedirectResponse $response): bool {
            return $response->getTargetUrl() === 'http://sylius.dev/admin/';
        }))->shouldBeCalled();

        $this->__invoke($event);
    }

    function it_does_nothing_if_administrator_has_access_to_given_route(
        AccessRequestCreatorInterface $accessRequestCreator,
        AdministratorAccessCheckerInterface $administratorAccessChecker,
        TokenStorageInterface $tokenStorage,
        GetResponseEvent $event,
        Request $request,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $event->getRequest()->willReturn($request);
        $request->attributes = new ParameterBag(['_route' => 'sylius_admin_some_route']);

        $accessRequest = new AccessRequest(Section::catalog(), OperationType::write());
        $accessRequestCreator->createFromRouteName('sylius_admin_some_route')->willReturn($accessRequest);

        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($adminUser);

        $administratorAccessChecker->hasAccessToSection($adminUser, $accessRequest)->willReturn(true);

        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->__invoke($event);
    }

    function it_does_nothing_if_route_is_not_secured_with_rbac_system(
        AccessRequestCreatorInterface $accessRequestCreator,
        GetResponseEvent $event,
        Request $request
    ): void {
        $event->getRequest()->willReturn($request);
        $request->attributes = new ParameterBag(['_route' => 'sylius_admin_some_route']);

        $accessRequestCreator
            ->createFromRouteName('sylius_admin_some_route')
            ->willThrow(UnresolvedRouteNameException::withRouteName('sylius_admin_some_route'))
        ;

        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->__invoke($event);
    }

    function it_does_nothing_if_route_is_not_from_admin_panel(
        AccessRequestCreatorInterface $accessRequestCreator,
        GetResponseEvent $event,
        Request $request
    ): void {
        $event->getRequest()->willReturn($request);
        $request->attributes = new ParameterBag(['_route' => 'sylius_shop_some_route']);

        $accessRequestCreator->createFromRouteName('sylius_admin_some_route')->shouldNotBeCalled();

        $this->__invoke($event);
    }
}
