<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Model;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;

final class AccessRequestSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(Section::customers(), OperationType::read());
    }

    function it_has_permission(): void
    {
        $this->section()->shouldBeLike(Section::customers());
    }

    function it_has_operation_type(): void
    {
        $this->operationType()->shouldBeLike(OperationType::read());
    }
}
