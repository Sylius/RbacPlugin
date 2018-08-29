<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusRbacPlugin extends Bundle
{
    use SyliusPluginTrait;
}
