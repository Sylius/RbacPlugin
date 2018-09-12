<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Form\Type;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AdministrationRoleChoiceType extends AbstractType
{
    /** @var ObjectRepository */
    private $administrationRoleRepository;

    public function __construct(ObjectRepository $administrationRoleRepository)
    {
        $this->administrationRoleRepository = $administrationRoleRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'choices' => $this->administrationRoleRepository->findAll(),
            'choice_value' => 'id',
            'choice_label' => 'name',
//            'label' => 'sylius.form.locale.locale',
//            'placeholder' => 'sylius.form.locale.select',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'sylius_rbac_administration_role_choice';
    }
}
