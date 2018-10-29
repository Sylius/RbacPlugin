<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Creator;

use PhpSpec\ObjectBehavior;
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
            'permissions' => ['catalog_management', 'configuration'],
        ];

        $this->fromRequest($request)->shouldBeCommandWithPayload($payload);
    }

    public function getMatchers(): array
    {
        return [
            'beCommandWithPayload' => function ($subject, $payload) {
                return $subject->administrationRoleName() === $payload['administration_role_name'] &&
                    $subject->permissions() === $payload['permissions'];
            },
        ];
    }
}
