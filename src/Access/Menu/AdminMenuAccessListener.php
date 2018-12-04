<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

final class AdminMenuAccessListener
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var AdministratorAccessCheckerInterface */
    private $accessChecker;

    /** @var array */
    private $configuration;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AdministratorAccessCheckerInterface $accessChecker,
        array $configuration
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->accessChecker = $accessChecker;
        $this->configuration = $configuration;
    }

    public function removeInaccessibleAdminMenuParts(MenuBuilderEvent $event): void
    {
        $token = $this->tokenStorage->getToken();
        Assert::notNull($token, 'There is no logged in user');

        /** @var AdminUserInterface $adminUser */
        $adminUser = $token->getUser();
        Assert::isInstanceOf($adminUser, AdminUserInterface::class, 'Logged in user should be and administrator');

        $menu = $event->getMenu();

        if ($this->hasAdminNoAccessToSection($adminUser, Section::catalog())) {
            $menu->removeChild('catalog');
        }

        if ($this->hasAdminNoAccessToSection($adminUser, Section::configuration())) {
            $menu->removeChild('configuration');
        }

        if ($this->hasAdminNoAccessToSection($adminUser, Section::customers())) {
            $menu->removeChild('customers');
        }

        if ($this->hasAdminNoAccessToSection($adminUser, Section::marketing())) {
            $menu->removeChild('marketing');
        }

        if ($this->hasAdminNoAccessToSection($adminUser, Section::sales())) {
            $menu->removeChild('sales');
        }

        /** @var string $customSection */
        foreach (array_keys($this->configuration['custom']) as $customSection) {
            if ($this->hasAdminNoAccessToSection($adminUser, Section::ofType($customSection))) {
                $menu->removeChild($customSection);
            }
        }
    }

    private function hasAdminNoAccessToSection(AdminUserInterface $adminUser, Section $section): bool
    {
        return !$this->accessChecker->canAccessSection(
            $adminUser,
            new AccessRequest($section, OperationType::read())
        );
    }
}
