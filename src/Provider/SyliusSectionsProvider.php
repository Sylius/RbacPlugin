<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

final class SyliusSectionsProvider implements SyliusSectionsProviderInterface
{
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
                array_keys($this->rbacConfiguration['custom'])
            ),
            ['custom']
        );

        // there's a gap between indexes after merging two arrays and then removing one of the elements
        $rearrangedArray = array_values($mergedArray);

        return $rearrangedArray;
    }
}
