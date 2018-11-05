<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Action;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Extractor\PermissionDataExtractorInterface;
use Sylius\RbacPlugin\Provider\AdminPermissionsProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class UpdateAdministrationRoleViewAction
{
    /** @var AdminPermissionsProviderInterface */
    private $adminPermissionsProvider;

    /** @var RepositoryInterface */
    private $administrationRolesRepository;

    /** @var PermissionDataExtractorInterface */
    private $permissionDataExtractor;

    /** @var Environment */
    private $twig;

    /** @var UrlGeneratorInterface */
    private $router;

    public function __construct(
        AdminPermissionsProviderInterface $adminPermissionsProvider,
        RepositoryInterface $administrationRolesRepository,
        PermissionDataExtractorInterface $permissionDataExtractor,
        Environment $twig,
        UrlGeneratorInterface $router
    ) {
        $this->adminPermissionsProvider = $adminPermissionsProvider;
        $this->administrationRolesRepository = $administrationRolesRepository;
        $this->permissionDataExtractor = $permissionDataExtractor;
        $this->twig = $twig;
        $this->router = $router;
    }

    public function __invoke(Request $request): Response
    {
        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this->administrationRolesRepository->find($request->attributes->get('id'));

        return new Response(
            $this->twig->render('@SyliusRbacPlugin/AdministrationRole/update.html.twig', [
                'administration_role' => $administrationRole,
                'permissions' => $this->adminPermissionsProvider->getPossiblePermissions(),
                'rolePermissions' => $administrationRole->getPermissions(),
            ])
        );
    }
}
