<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Service;

use FriendsOfBehat\PageObjectExtension\Page\PageInterface;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;

final class PagesAvailabilityChecker
{
    /** @var array|PageInterface[] */
    private $pages;

    public function __construct(array $pages)
    {
        $this->pages = $pages;
    }

    public function areAllPagesAvailable(): bool
    {
        /** @var PageInterface $page */
        foreach ($this->pages as $page) {
            try {
                $page->open();
            } catch (UnexpectedPageException $exception) {
                continue;
            }

            if (!$page->isOpen()) {
                return false;
            }
        }

        return true;
    }

    public function areAllPagesUnavailable(): bool
    {
        /** @var PageInterface $page */
        foreach ($this->pages as $page) {
            try {
                $page->open();
            } catch (UnexpectedPageException $exception) {
                continue;
            }

            if ($page->isOpen()) {
                return false;
            }
        }

        return true;
    }
}
