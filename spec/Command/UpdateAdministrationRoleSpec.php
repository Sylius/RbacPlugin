<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Command;

use PhpSpec\ObjectBehavior;

final class UpdateAdministrationRoleSpec extends ObjectBehavior
{
    function it_represents_an_intention_to_update_administration_role(): void
    {
        $this->beConstructedWith('1', 'Product Manager', ['catalog_management', 'configuration']);

        $this->administrationRoleId()->shouldReturn(1);
        $this->administrationRoleName()->shouldReturn('Product Manager');
        $this->permissions()->shouldReturn(['catalog_management', 'configuration']);
    }
}
