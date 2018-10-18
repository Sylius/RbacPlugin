<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Action;

use Sylius\RbacPlugin\Provider\AdminPermissionsProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class NewAdministrationRoleCreatorAction
{
    /** @var AdminPermissionsProviderInterface */
    private $adminPermissionsProvider;

    /** @var Environment */
    private $twig;

    /** @var UrlGeneratorInterface */
    private $router;

    public function __construct(
        AdminPermissionsProviderInterface $adminPermissionsProvider,
        Environment $twig,
        UrlGeneratorInterface $router
    ) {
        $this->adminPermissionsProvider = $adminPermissionsProvider;
        $this->twig = $twig;
        $this->router = $router;
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
