<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Application\src\Entity;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use Sylius\RbacPlugin\Entity\AdministrationRoleAwareInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleTrait;

/**
 * @MappedSuperclass
 * @Table(name="sylius_admin_user")
 */
final class AdminUser implements AdministrationRoleAwareInterface
{
    use AdministrationRoleTrait;
}
