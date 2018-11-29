<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Service;

use Behat\Mink\Exception\ElementNotFoundException;
use Sylius\Behat\Exception\NotificationExpectationMismatchException;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\Admin\Crud\CreatePageInterface;
use Sylius\Behat\Service\NotificationChecker;
use Sylius\Behat\Service\NotificationCheckerInterface;

final class ModifyingAvailabilityChecker
{
    /** @var CreatePageInterface */
    private $createPage;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    public function __construct(CreatePageInterface $createPage, NotificationChecker $notificationChecker)
    {
        $this->createPage = $createPage;
        $this->notificationChecker = $notificationChecker;
    }

    public function isModifyingAvailable(): bool
    {
        $this->createPage->open();
        $this->createPage->create();

        try {
            $this->notificationChecker->checkNotification(
                'You are not allowed to do that',
                NotificationType::failure()
            );
        } catch (ElementNotFoundException $exception) {
            return true;
        } catch (NotificationExpectationMismatchException $exception) {
            return true;
        }

        return false;
    }
}
