<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Provider\AdminPermissionsProviderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class AdministrationRoleType extends AbstractResourceType
{
    /** @var AdminPermissionsProviderInterface */
    private $adminPermissionsProvider;

    public function __construct(
        string $dataClass,
        array $validationGroups,
        AdminPermissionsProviderInterface $adminPermissionsProvider
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->adminPermissionsProvider = $adminPermissionsProvider;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = [];
        foreach (($this->adminPermissionsProvider)() as $permission) {
            $choices['sylius_rbac.ui.permission.'.$permission] = $permission;
        }

        $builder
            ->add('name', TextType::class, ['label' => 'sylius.ui.name'])
            ->add('permissions', ChoiceType::class, [
                'label' => false,
                'choices' => $choices,
                'multiple' => true,
            ])
        ;

        $builder->get('permissions')->addModelTransformer(new CallbackTransformer(
            function (array $permissions): array {
                if (empty($permissions)) {
                    return [];
                }

                return array_map(function (Permission $permission): string {
                    return $permission->type();
                }, $permissions);
            },
            function (array $permissions): array {
                if (empty($permissions)) {
                    return [];
                }

                return array_map(function (string $permission): Permission {
                    return new Permission($permission);
                }, $permissions);
            }
        ));
    }

    public function getBlockPrefix()
    {
        return 'sylius_rbac_administration_role';
    }
}
