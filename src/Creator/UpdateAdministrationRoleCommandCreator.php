<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Prooph\Common\Messaging\Command;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Extractor\RequestAdministrationRolePermissionsExtractorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAdministrationRoleCommandCreator implements CommandCreatorInterface
{
    /** @var RequestAdministrationRolePermissionsExtractorInterface */
    private $requestAdministrationROlePermissionsExtractor;

    public function __construct(
        RequestAdministrationRolePermissionsExtractorInterface $requestAdministrationROlePermissionsExtractor
    ) {
        $this->requestAdministrationROlePermissionsExtractor = $requestAdministrationROlePermissionsExtractor;
    }

    public function fromRequest(Request $request): Command
    {
        /** @var ParameterBag $requestAttributes */
        $requestAttributes = $request->request;

        $permissions = $this->requestAdministrationROlePermissionsExtractor->extract($requestAttributes->all());

        $command = new UpdateAdministrationRole(
            (int) $request->attributes->get('id'),
            $requestAttributes->get('administration_role_name'),
            $permissions
        );

        return $command;
    }
}
