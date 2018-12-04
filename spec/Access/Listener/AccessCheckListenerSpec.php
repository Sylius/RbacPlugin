<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Checker\RouteNameCheckerInterface;
use Sylius\RbacPlugin\Access\Creator\AccessRequestCreatorInterface;
use Sylius\RbacPlugin\Access\Exception\UnresolvedRouteNameException;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
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
        UrlGeneratorInterface $router,
        Session $session,
        RouteNameCheckerInterface $adminRouteChecker
    ): void {
        $this->beConstructedWith(
            $accessRequestCreator,
            $administratorAccessChecker,
            $tokenStorage,
            $router,
            $session,
            $adminRouteChecker
        );
    }

    function it_redirects_to_admin_dashboard_if_admin_does_not_have_access_to_target_route(
        AccessRequestCreatorInterface $accessRequestCreator,
        AdministratorAccessCheckerInterface $administratorAccessChecker,
        RouteNameCheckerInterface $adminRouteChecker,
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $router,
        Session $session,
        GetResponseEvent $event,
        Request $request,
        TokenInterface $token,
        AdminUserInterface $adminUser,
        FlashBagInterface $flashBag
    ): void {
        $event->isMasterRequest()->willReturn(true);
        $event->getRequest()->willReturn($request);
        $request->getMethod()->willReturn('GET');
        $request->attributes = new ParameterBag(['_route' => 'sylius_admin_some_route']);
        $request->headers = new HeaderBag(['referer' => null]);

        $adminRouteChecker->isAdminRoute('sylius_admin_some_route')->willReturn(true);

        $accessRequest = new AccessRequest(Section::catalog(), OperationType::read());
        $accessRequestCreator
            ->createFromRouteName('sylius_admin_some_route', 'GET')
            ->willReturn($accessRequest)
        ;

        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($adminUser);

        $administratorAccessChecker->canAccessSection($adminUser, $accessRequest)->willReturn(false);
        $router->generate('sylius_admin_dashboard')->willReturn('http://sylius.dev/admin/');

        $event->setResponse(Argument::that(function (RedirectResponse $response): bool {
            return $response->getTargetUrl() === 'http://sylius.dev/admin/';
        }))->shouldBeCalled();

        $session->getFlashBag()->willReturn($flashBag);
        $flashBag->add('error', 'sylius_rbac.you_have_no_access_to_this_section')->shouldBeCalled();

        $this->onKernelRequest($event);
    }

    function it_does_nothing_if_administrator_has_access_to_given_route(
        AccessRequestCreatorInterface $accessRequestCreator,
        AdministratorAccessCheckerInterface $administratorAccessChecker,
        RouteNameCheckerInterface $adminRouteChecker,
        TokenStorageInterface $tokenStorage,
        GetResponseEvent $event,
        Request $request,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $event->isMasterRequest()->willReturn(true);
        $event->getRequest()->willReturn($request);
        $request->getMethod()->willReturn('GET');
        $request->attributes = new ParameterBag(['_route' => 'sylius_admin_some_route']);
        $request->headers = new HeaderBag(['referer' => null]);

        $adminRouteChecker->isAdminRoute('sylius_admin_some_route')->willReturn(true);

        $accessRequest = new AccessRequest(Section::catalog(), OperationType::write());
        $accessRequestCreator
            ->createFromRouteName('sylius_admin_some_route', 'GET')
            ->willReturn($accessRequest)
        ;

        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($adminUser);

        $administratorAccessChecker->canAccessSection($adminUser, $accessRequest)->willReturn(true);

        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }

    function it_does_nothing_if_route_is_not_secured_with_rbac_system(
        AccessRequestCreatorInterface $accessRequestCreator,
        RouteNameCheckerInterface $adminRouteChecker,
        GetResponseEvent $event,
        Request $request
    ): void {
        $event->isMasterRequest()->willReturn(true);
        $event->getRequest()->willReturn($request);
        $request->getMethod()->willReturn('GET');
        $request->attributes = new ParameterBag(['_route' => 'sylius_admin_some_route']);
        $request->headers = new HeaderBag(['referer' => null]);

        $adminRouteChecker->isAdminRoute('sylius_admin_some_route')->willReturn(true);

        $accessRequestCreator
            ->createFromRouteName('sylius_admin_some_route', 'GET')
            ->willThrow(UnresolvedRouteNameException::withRouteName('sylius_admin_some_route'))
        ;

        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }

    function it_does_nothing_if_route_is_not_from_admin_panel(
        AccessRequestCreatorInterface $accessRequestCreator,
        RouteNameCheckerInterface $adminRouteChecker,
        GetResponseEvent $event,
        Request $request
    ): void {
        $event->isMasterRequest()->willReturn(true);
        $event->getRequest()->willReturn($request);
        $request->getMethod()->willReturn('GET');
        $request->attributes = new ParameterBag(['_route' => 'sylius_shop_some_route']);
        $request->headers = new HeaderBag(['referer' => null]);

        $adminRouteChecker->isAdminRoute('sylius_shop_some_route')->willReturn(false);

        $accessRequestCreator->createFromRouteName('sylius_shop_some_route')->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }

    function it_does_nothing_if_request_is_not_master_request(GetResponseEvent $event): void
    {
        $event->isMasterRequest()->willReturn(false);

        $event->getRequest()->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }
}
