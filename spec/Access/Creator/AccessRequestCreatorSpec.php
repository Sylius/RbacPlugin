<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Creator;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Creator\AccessRequestCreatorInterface;
use Sylius\RbacPlugin\Access\Exception\UnresolvedRouteNameException;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;

final class AccessRequestCreatorSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(
            [
                'catalog' => ['sylius_admin_weapons'],
                'configuration' => [],
                'customers' => ['sylius_admin_customers'],
                'marketing' => [],
                'sales' => [],
                'custom' => ['custom_section' => ['sylius_custom_section_route']],
            ],
            'GET'
        );
    }

    function it_implements_access_request_creator_interface(): void
    {
        $this->shouldImplement(AccessRequestCreatorInterface::class);
    }

    function it_creates_access_request_with_write_operation_type_from_route_name(): void
    {
        $this
            ->createFromRouteName('sylius_admin_weapons_index', 'POST')
            ->shouldBeLike(new AccessRequest(Section::catalog(), OperationType::write()))
        ;
    }

    function it_creates_access_request_with_read_operation_type_from_route_name(): void
    {
        $this
            ->createFromRouteName('sylius_admin_weapons_index', 'GET')
            ->shouldBeLike(new AccessRequest(Section::catalog(), OperationType::read()))
        ;

        $this
            ->createFromRouteName('sylius_custom_section_route_index', 'GET')
            ->shouldBeLike(new AccessRequest(Section::ofType('custom_section'), OperationType::read()))
        ;
    }

    function it_throws_exception_if_route_name_cannot_be_resolved(): void
    {
        $this
            ->shouldThrow(UnresolvedRouteNameException::withRouteName('sylius_admin_invalid_route_name'))
            ->during('createFromRouteName', ['sylius_admin_invalid_route_name', 'GET'])
        ;
    }
}
