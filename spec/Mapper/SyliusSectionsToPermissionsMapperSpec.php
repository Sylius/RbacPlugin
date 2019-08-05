<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Mapper;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Model\Section;
use Sylius\RbacPlugin\Mapper\SectionsToPermissionsMapperInterface;
use Sylius\RbacPlugin\Model\Permission;

final class SyliusSectionsToPermissionsMapperSpec extends ObjectBehavior
{
    public function it_implements_sections_to_permissions_mapper_interface(): void
    {
        $this->shouldImplement(SectionsToPermissionsMapperInterface::class);
    }

    public function it_returns_permission_key_for_known_sylius_section(): void
    {
        $this->map(Section::CONFIGURATION)->shouldReturn(Permission::CONFIGURATION_PERMISSION);
    }

    public function it_returns_section_key_for_unknown_sylius_section(): void
    {
        $this->map('unknown_section')->shouldReturn('unknown_section');
    }
}
