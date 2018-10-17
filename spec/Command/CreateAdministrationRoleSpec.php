<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Command;

use PhpSpec\ObjectBehavior;

final class CreateAdministrationRoleSpec extends ObjectBehavior
{
    function it_represents_an_intention_to_create_an_administration_role(): void
    {
        $this->beConstructedWith('rick_sanchez', ['catalog_management', 'configuration']);

        $this->administrationRoleName()->shouldReturn('rick_sanchez');
        $this->permissions()->shouldReturn(['catalog_management', 'configuration']);
    }
}
