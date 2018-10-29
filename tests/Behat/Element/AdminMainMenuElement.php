<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Element;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Element\Element;

final class AdminMainMenuElement extends Element implements AdminMainMenuElementInterface
{
    public function getAvailableSections(): array
    {
        return array_map(function(NodeElement $header): string {
            return $header->getText();
        }, $this->getDocument()->findAll('css', '#sidebar .item .header'));
    }
}
