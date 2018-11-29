<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Model;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Model\Section;

final class SectionSpec extends ObjectBehavior
{
    function it_can_be_catalog_section(): void
    {
        $this->beConstructedThrough(Section::CATALOG);

        $this->__toString()->shouldReturn(Section::CATALOG);
    }

    function it_can_be_configuration_section(): void
    {
        $this->beConstructedThrough(Section::CONFIGURATION);

        $this->__toString()->shouldReturn(Section::CONFIGURATION);
    }

    function it_can_be_customers_section(): void
    {
        $this->beConstructedThrough(Section::CUSTOMERS);

        $this->__toString()->shouldReturn(Section::CUSTOMERS);
    }

    function it_can_be_marketing_section(): void
    {
        $this->beConstructedThrough(Section::MARKETING);

        $this->__toString()->shouldReturn(Section::MARKETING);
    }

    function it_can_be_sales_section(): void
    {
        $this->beConstructedThrough(Section::SALES);

        $this->__toString()->shouldReturn(Section::SALES);
    }

    function it_can_be_custom(): void
    {
        $this->beConstructedThrough('ofType', ['custom_section']);

        $this->__toString()->shouldReturn('custom_section');
    }

    function it_can_be_compared_with_other_section(): void
    {
        $this->beConstructedThrough(Section::SALES);

        $this->equals(Section::sales())->shouldReturn(true);
        $this->equals(Section::catalog())->shouldReturn(false);
    }
}
