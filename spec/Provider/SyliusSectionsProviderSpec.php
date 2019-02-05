<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Provider;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Provider\SyliusSectionsProviderInterface;

final class SyliusSectionsProviderSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith([
                'catalog' => [
                    'sylius_admin_inventory',
                    'sylius_admin_product',
                    'sylius_admin_product_association_type',
                    'sylius_admin_product_attribute',
                    'sylius_admin_product_option',
                    'sylius_admin_product_variant',
                    'sylius_admin_taxon',
                ],
                'configuration' => [
                    'sylius_admin_admin_user',
                    'sylius_admin_channel',
                    'sylius_admin_country',
                    'sylius_admin_currency',
                    'sylius_admin_exchange_rate',
                    'sylius_admin_locale',
                    'sylius_admin_payment_method',
                    'sylius_admin_shipping_category',
                    'sylius_admin_shipping_method',
                    'sylius_admin_tax_category',
                    'sylius_admin_tax_rate',
                    'sylius_admin_zone',
                ],
                'customers' => [
                    'sylius_admin_customer',
                    'sylius_admin_customer_group',
                    'sylius_admin_shop_user',
                ],
                'marketing' => [
                    'sylius_admin_product_review',
                    'sylius_admin_promotion',
                ],
                'sales' => [
                    'sylius_admin_order',
                ],
                'custom' => [
                    'rbac' => [
                        'sylius_rbac',
                    ],
                ],
            ]
        );
    }

    public function it_implements_sylius_sections_provider_interface(): void
    {
        $this->shouldImplement(SyliusSectionsProviderInterface::class);
    }

    public function it_returns_both_standard_and_custom_sylius_sections_combined(): void
    {
        $this->__invoke()->shouldReturn([
            'catalog',
            'configuration',
            'customers',
            'marketing',
            'sales',
            'rbac',
        ]);
    }
}
