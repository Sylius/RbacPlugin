<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

final class SyliusSectionsProvider implements SyliusSectionsProviderInterface
{
    private const CUSTOM_SECTION_CONFIGURATION_KEY = 'custom';

    /** @var array */
    private $rbacConfiguration;

    public function __construct(array $rbacConfiguration)
    {
        $this->rbacConfiguration = $rbacConfiguration;
    }

    public function __invoke(): array
    {
        $mergedArray = array_diff(
            array_merge(
                array_keys($this->rbacConfiguration),
                array_keys($this->rbacConfiguration[self::CUSTOM_SECTION_CONFIGURATION_KEY])
            ),
            [self::CUSTOM_SECTION_CONFIGURATION_KEY]
        );

        return $this->rearrangeArray($mergedArray);
    }

    private function rearrangeArray(array $arrayToRearrange): array
    {
        return array_values($arrayToRearrange);
    }
}
