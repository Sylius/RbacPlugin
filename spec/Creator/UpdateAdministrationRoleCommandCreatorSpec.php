<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Creator;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Creator\CommandCreatorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAdministrationRoleCommandCreatorSpec extends ObjectBehavior
{
    function it_implements_command_creator_interface(): void
    {
        $this->shouldImplement(CommandCreatorInterface::class);
    }

    function it_creates_update_administration_role_command_from_request(Request $request): void
    {
        $request->request = new ParameterBag([
            'administration_role_name' => 'rick_sanchez',
            'permissions' => [
                'catalog_management',
                'configuration',
            ],
        ]);

        $request->attributes = new ParameterBag([
            'id' => 1,
        ]);

        $payload = [
            'administration_role_id' => 1,
            'administration_role_name' => 'rick_sanchez',
            'permissions' => ['catalog_management', 'configuration']
        ];

        $command = $this->fromRequest($request);

        $command->shouldHaveType(UpdateAdministrationRole::class);
        $command->payload()->shouldBeLike($payload);
    }
}
