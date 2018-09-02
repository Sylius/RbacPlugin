<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Entity;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;

final class AdministrationRoleSpec extends ObjectBehavior
{
    function it_implements_administration_role_interface(): void
    {
        $this->shouldImplement(AdministrationRoleInterface::class);
    }

    function it_has_name(): void
    {
        $this->setName('Root');
        $this->getName()->shouldReturn('Root');
    }
}
