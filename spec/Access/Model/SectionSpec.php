<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Model;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Model\Section;

final class SectionSpec extends ObjectBehavior
{
    function it_can_be_catalog_section(): void
    {
        $this->beConstructedThrough('catalog');

        $this->__toString()->shouldReturn(Section::CATALOG);
    }

    function it_can_be_configuration_section(): void
    {
        $this->beConstructedThrough('configuration');

        $this->__toString()->shouldReturn(Section::CONFIGURATION);
    }

    function it_can_be_customers_section(): void
    {
        $this->beConstructedThrough('customers');

        $this->__toString()->shouldReturn(Section::CUSTOMERS);
    }

    function it_can_be_marketing_section(): void
    {
        $this->beConstructedThrough('marketing');

        $this->__toString()->shouldReturn(Section::MARKETING);
    }

    function it_can_be_sales_section(): void
    {
        $this->beConstructedThrough('sales');

        $this->__toString()->shouldReturn(Section::SALES);
    }

    function it_cannot_be_other_section_than_allowed(): void
    {
        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('__construct', ['other_section'])
        ;
    }

    function it_can_be_compared_with_other_section(): void
    {
        $this->beConstructedThrough('sales');

        $this->equals(Section::sales())->shouldReturn(true);
        $this->equals(Section::catalog())->shouldReturn(false);
    }
}
