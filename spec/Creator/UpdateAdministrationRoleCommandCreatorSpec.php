<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Creator;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Creator\CommandCreatorInterface;
use Sylius\RbacPlugin\Extractor\RequestAdministrationRolePermissionsExtractorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAdministrationRoleCommandCreatorSpec extends ObjectBehavior
{
    function let(
        RequestAdministrationRolePermissionsExtractorInterface $requestAdministrationRolePermissionsExtractor
    ): void {
        $this->beConstructedWith($requestAdministrationRolePermissionsExtractor);
    }

    function it_implements_command_creator_interface(): void
    {
        $this->shouldImplement(CommandCreatorInterface::class);
    }

    function it_creates_update_administration_role_command_from_request(
        RequestAdministrationRolePermissionsExtractorInterface $requestAdministrationRolePermissionsExtractor,
        Request $request
    ): void {
        $request->request = new ParameterBag([
            'administration_role_name' => 'Product Manager',
            'permissions' => [
                'catalog_management~read',
                'catalog_management~write',
                'configuration~read',
            ],
        ]);

        $request->attributes = new ParameterBag(['id' => 1]);

        $requestAdministrationRolePermissionsExtractor
            ->extract($request->request->all())
            ->willReturn(
                [
                    'catalog_management' => ['read', 'write'],
                    'configuration' => ['read'],
                ]
            );

        $payload = [
            'administration_role_id' => 1,
            'administration_role_name' => 'Product Manager',
            'permissions' => [
                    'catalog_management' => ['read', 'write'],
                    'configuration' => ['read'],
                ],
        ];

        $this->fromRequest($request)->shouldBeCommandWithPayload($payload);
    }

    public function getMatchers(): array
    {
        return [
            'beCommandWithPayload' => function (UpdateAdministrationRole $subject, array $payload): bool {
                return
                    $subject->administrationRoleId() === $payload['administration_role_id'] &&
                    $subject->administrationRoleName() === $payload['administration_role_name'] &&
                    $subject->permissions() === $payload['permissions']
                ;
            },
        ];
    }
}
