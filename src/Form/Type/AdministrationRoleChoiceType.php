<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Form\Type;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AdministrationRoleChoiceType extends AbstractType
{
    /** @var ObjectRepository */
    private $administrationRoleRepository;

    public function __construct(ObjectRepository $administrationRoleRepository)
    {
        $this->administrationRoleRepository = $administrationRoleRepository;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'choices' => $this->administrationRoleRepository->findAll(),
            'choice_value' => 'id',
            'choice_label' => 'name',
            'label' => false,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_rbac_administration_role_choice';
    }
}
