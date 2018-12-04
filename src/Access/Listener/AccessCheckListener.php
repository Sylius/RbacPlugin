<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Listener;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Checker\RouteNameCheckerInterface;
use Sylius\RbacPlugin\Access\Creator\AccessRequestCreatorInterface;
use Sylius\RbacPlugin\Access\Exception\InsecureRequestException;
use Sylius\RbacPlugin\Access\Exception\UnresolvedRouteNameException;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

final class AccessCheckListener
{
    /** @var AccessRequestCreatorInterface */
    private $accessRequestCreator;

    /** @var AdministratorAccessCheckerInterface */
    private $administratorAccessChecker;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var UrlGeneratorInterface */
    private $router;

    /** @var Session */
    private $session;

    /** @var RouteNameCheckerInterface */
    private $adminRouteChecker;

    public function __construct(
        AccessRequestCreatorInterface $accessRequestCreator,
        AdministratorAccessCheckerInterface $administratorAccessChecker,
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $router,
        Session $session,
        RouteNameCheckerInterface $adminRouteChecker
    ) {
        $this->accessRequestCreator = $accessRequestCreator;
        $this->administratorAccessChecker = $administratorAccessChecker;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->session = $session;
        $this->adminRouteChecker = $adminRouteChecker;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        try {
            $accessRequest = $this->createAccessRequestFromEvent($event);
        } catch (InsecureRequestException $exception) {
            return;
        }

        if ($this->administratorAccessChecker->canAccessSection($this->getCurrentAdmin(), $accessRequest)) {
            return;
        }

        $this->addAccessErrorFlash($event->getRequest()->getMethod());
        $event->setResponse($this->getRedirectResponse($event->getRequest()->headers->get('referer')));
    }

    /** @throws InsecureRequestException */
    private function createAccessRequestFromEvent(GetResponseEvent $event): AccessRequest
    {
        if (!$event->isMasterRequest()) {
            throw new InsecureRequestException();
        }

        $routeName = $event->getRequest()->attributes->get('_route');
        $requestMethod = $event->getRequest()->getMethod();

        if ($routeName === null) {
            throw new InsecureRequestException();
        }

        if (!$this->adminRouteChecker->isAdminRoute($routeName)) {
            throw new InsecureRequestException();
        }

        try {
            $accessRequest = $this->accessRequestCreator->createFromRouteName($routeName, $requestMethod);
        } catch (UnresolvedRouteNameException $exception) {
            throw new InsecureRequestException();
        }

        return $accessRequest;
    }

    private function getCurrentAdmin(): AdminUserInterface
    {
        $token = $this->tokenStorage->getToken();
        Assert::notNull($token);

        /** @var AdminUserInterface|null $currentAdmin */
        $currentAdmin = $token->getUser();
        Assert::isInstanceOf($currentAdmin, UserInterface::class);

        return $currentAdmin;
    }

    private function addAccessErrorFlash(string $requestMethod): void
    {
        if ('GET' === $requestMethod || 'HEAD' === $requestMethod) {
            $this->session->getFlashBag()->add('error', 'sylius_rbac.you_have_no_access_to_this_section');

            return;
        }

        $this->session->getFlashBag()->add('error', 'sylius_rbac.you_are_not_allowed_to_do_that');
    }

    private function getRedirectResponse(?string $referer): RedirectResponse
    {
        if (null !== $referer) {
            return new RedirectResponse($referer);
        }

        return new RedirectResponse($this->router->generate('sylius_admin_dashboard'));
    }
}
