<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Action;

use Sylius\RbacPlugin\Provider\AdminPermissionsProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class CreateAdministrationRoleViewAction
{
    /** @var AdminPermissionsProviderInterface */
    private $adminPermissionsProvider;

    /** @var Environment */
    private $twig;

    public function __construct(
        AdminPermissionsProviderInterface $adminPermissionsProvider,
        Environment $twig
    ) {
        $this->adminPermissionsProvider = $adminPermissionsProvider;
        $this->twig = $twig;
    }

    public function __invoke(): Response
    {
        return new Response(
            $this->twig->render('@SyliusRbacPlugin/AdministrationRole/create.html.twig', [
                'permissions' => $this->adminPermissionsProvider->getPossiblePermissions(),
            ])
        );
    }
}
