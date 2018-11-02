<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Model;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Model\OperationType;

final class OperationTypeSpec extends ObjectBehavior
{
    function it_can_represent_write_operation_type(): void
    {
        $this->beConstructedThrough('write');

        $this->__toString()->shouldReturn(OperationType::WRITE);
    }

    function it_can_represent_read_operation_type(): void
    {
        $this->beConstructedThrough('read');

        $this->__toString()->shouldReturn(OperationType::READ);
    }

    function it_cannot_be_other_than_read_or_write(): void
    {
        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('__construct', ['other_type'])
        ;
    }
}
