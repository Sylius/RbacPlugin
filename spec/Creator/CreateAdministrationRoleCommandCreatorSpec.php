<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Creator;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Creator\CommandCreatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class CreateAdministrationRoleCommandCreatorSpec extends ObjectBehavior
{
    function it_implements_command_creator_interface(): void
    {
        $this->shouldImplement(CommandCreatorInterface::class);
    }

    function it_creates_create_administration_role_command_from_request(Request $request): void
    {
        $request->request = new ParameterBag([
            'administration_role_name' => 'rick_sanchez',
            'permissions' => [
                'catalog_management',
                'configuration',
            ],
        ]);

        $payload = [
            'administration_role_name' => 'rick_sanchez',
            'permissions' => ['catalog_management', 'configuration']
        ];

        $command = $this->fromRequest($request);

        $command->shouldHaveType(CreateAdministrationRole::class);
        $command->payload()->shouldBeLike($payload);
    }

    function it_throws_an_exception_when_administration_role_name_is_not_provided(Request $request): void
    {
        $request->request = new ParameterBag([
            'permissions' => [
                'catalog_management',
                'configuration',
            ],
        ]);

        $this->shouldThrow(\InvalidArgumentException::class)->during('fromRequest', [$request]);
    }

    function it_throws_an_exception_when_permissions_are_not_provided(Request $request): void
    {
        $request->request = new ParameterBag([
            'administration_role_name' => 'rick_sanchez',
        ]);

        $this->shouldThrow(\InvalidArgumentException::class)->during('fromRequest', [$request]);
    }
}
