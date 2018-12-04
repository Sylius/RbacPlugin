<?php

declare(strict_types=1);

namespace Tests\Application\RbacPlugin\Entity;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleAwareInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleTrait;

/**
 * @MappedSuperclass()
 * @Table(name="sylius_admin_user")
 * @final
 */
class AdminUser extends BaseAdminUser implements AdminUserInterface, AdministrationRoleAwareInterface
{
    use AdministrationRoleTrait;
}
