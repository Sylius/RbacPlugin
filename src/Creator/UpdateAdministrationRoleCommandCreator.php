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

        if (!(
            $request->attributes->has('id')) &&
            $requestAttributes->has('administration_role_name') &&
            $requestAttributes->has('permissions')
        ) {
            throw new \InvalidArgumentException(
                'Expected request to contain administration role name, its permissions and id'
            );
        }

        $command = new UpdateAdministrationRole(
            $request->attributes->get('id'),
            $requestAttributes->get('administration_role_name'),
            $requestAttributes->get('permissions')
        );

        return $command;
    }
}
