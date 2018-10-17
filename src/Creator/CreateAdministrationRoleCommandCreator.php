<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Prooph\Common\Messaging\Command;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class CreateAdministrationRoleCommandCreator implements CommandCreatorInterface
{
    public function fromRequest(Request $request): Command
    {
        /** @var ParameterBag $requestAttributes */
        $requestAttributes = $request->attributes;

        if (!($requestAttributes->has('administration_role_name') && $requestAttributes->has('permissions'))) {
            throw new \InvalidArgumentException(
                'Expected request to contain administration role name and its permissions'
            );
        }

        $command = new CreateAdministrationRole(
            $requestAttributes->get('administration_role_name'),
            $requestAttributes->get('permissions')
        );

        return $command;
    }
}
