<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Entity;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Entity\AdminUser;
use Sylius\RbacPlugin\Entity\AdminUserInterface;

final class AdminUserSpec extends ObjectBehavior
{
    function let(AdministrationRoleInterface $administrationRole): void
    {
        $this->beConstructedWith($administrationRole);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AdminUser::class);
    }

    function it_implements_admin_user_interface(): void
    {
        $this->shouldImplement(AdminUserInterface::class);
    }

    function it_has_administration_role(): void
    {
        $this->getAdministrationRole()->shouldHaveType(AdministrationRoleInterface::class);
    }

    function it_accepts_nullable_administration_role(): void
    {
        $this->beConstructedWith(null);

        $this->getAdministrationRole()->shouldBeEqualTo(null);
    }
}
