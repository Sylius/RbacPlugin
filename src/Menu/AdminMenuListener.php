<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addRbacMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $rbacSection = $menu->addChild('rbac')->setLabel('sylius_rbac.ui.rbac');

        $rbacSection
            ->addChild('administration_roles', ['route' => 'sylius_rbac_admin_administration_role_index'])
            ->setLabel('sylius_rbac.ui.administration_roles')
            ->setLabelAttribute('icon', 'address card')
        ;
    }
}
