<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Prooph\Common\Messaging\Command;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Normalizer\AdministrationRolePermissionNormalizerInterface;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAdministrationRoleCommandCreator implements CommandCreatorInterface
{
    /** @var AdministrationRolePermissionNormalizerInterface */
    private $administrationRolePermissionNormalizer;

    public function __construct(AdministrationRolePermissionNormalizerInterface $administrationRolePermissionNormalizer)
    {
        $this->administrationRolePermissionNormalizer = $administrationRolePermissionNormalizer;
    }

    public function fromRequest(Request $request): Command
    {
        $normalizedPermissions = $this
            ->administrationRolePermissionNormalizer
            ->normalize($request->request->get('permissions', []))
        ;

        $command = new UpdateAdministrationRole(
            $request->attributes->getInt('id'),
            $request->request->get('administration_role_name'),
            $normalizedPermissions
        );

        return $command;
    }
}
