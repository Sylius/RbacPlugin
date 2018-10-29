<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Listener;

use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Creator\AccessRequestCreatorInterface;
use Sylius\RbacPlugin\Access\Exception\UnresolvedRouteNameException;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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

    public function __construct(
        AccessRequestCreatorInterface $accessRequestCreator,
        AdministratorAccessCheckerInterface $administratorAccessChecker,
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $router
    ) {
        $this->accessRequestCreator = $accessRequestCreator;
        $this->administratorAccessChecker = $administratorAccessChecker;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function __invoke(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $routeName = $event->getRequest()->get('_route');

        if ($routeName === null) {
            return;
        }

        if (strpos($routeName, 'sylius_admin') === false) {
            return;
        }

        try {
            $accessRequest = $this->accessRequestCreator->createFromRouteName($routeName);
        } catch (UnresolvedRouteNameException $exception) {
            return;
        }

        /** @var AdminUserInterface $currentAdmin */
        $currentAdmin = $this->tokenStorage->getToken()->getUser();

        if ($this->administratorAccessChecker->hasAccessToSection($currentAdmin, $accessRequest)) {
            return;
        }

        $event->setResponse(new RedirectResponse($this->router->generate('sylius_admin_dashboard')));
    }
}
