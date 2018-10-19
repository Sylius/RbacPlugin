<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Prooph\Common\Messaging\Command;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAdministrationRoleCommandCreator implements CommandCreatorInterface
{
    public function fromRequest(Request $request): Command
    {
        /** @var ParameterBag $requestAttributes */
        $requestAttributes = $request->request;

        $command = new UpdateAdministrationRole(
            (int) $request->attributes->get('id'),
            $requestAttributes->get('administration_role_name'),
            $requestAttributes->get('permissions')
        );

        return $command;
    }
}
