<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

final class AdminMenuAccessListener
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var AdministratorAccessCheckerInterface */
    private $accessChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AdministratorAccessCheckerInterface $accessChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->accessChecker = $accessChecker;
    }

    public function removeInaccessibleAdminMenuParts(MenuBuilderEvent $event): void
    {
        $token = $this->tokenStorage->getToken();
        Assert::notNull($token, 'There is no logged in user');

        /** @var AdminUserInterface $adminUser */
        $adminUser = $token->getUser();
        Assert::isInstanceOf($adminUser, AdminUserInterface::class, 'Logged in user should be and administrator');

        $menu = $event->getMenu();

        if ($this->hasAdminAccessToSection($adminUser, Section::catalog())) {
            $menu->removeChild('catalog');
        }

        if ($this->hasAdminAccessToSection($adminUser, Section::configuration())) {
            $menu->removeChild('configuration');
        }

        if ($this->hasAdminAccessToSection($adminUser, Section::customers())) {
            $menu->removeChild('customers');
        }

        if ($this->hasAdminAccessToSection($adminUser, Section::marketing())) {
            $menu->removeChild('marketing');
        }

        if ($this->hasAdminAccessToSection($adminUser, Section::sales())) {
            $menu->removeChild('sales');
        }

        if ($this->hasAdminAccessToSection($adminUser, Section::ofType('rbac'))) {
            $menu->removeChild('rbac');
        }
    }

    private function hasAdminAccessToSection(AdminUserInterface $adminUser, Section $section): bool
    {
        return !$this->accessChecker->canAccessSection(
            $adminUser,
            new AccessRequest($section, OperationType::write())
        );
    }
}
