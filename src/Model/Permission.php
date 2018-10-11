<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Model;

use Webmozart\Assert\Assert;

final class Permission
{
    public const CATALOG_MANAGEMENT_PERMISSION = 'catalog_management';
    public const CONFIGURATION_PERMISSION = 'configuration';
    public const CUSTOMERS_MANAGEMENT_PERMISSION = 'customers_management';
    public const MARKETING_MANAGEMENT_PERMISSION = 'marketing_management';
    public const SALES_MANAGEMENT_PERMISSION = 'sales_management';

    /** @var string */
    private $type;

    public static function catalogManagement(): self
    {
        return new self(self::CATALOG_MANAGEMENT_PERMISSION);
    }

    public static function configuration(): self
    {
        return new self(self::CONFIGURATION_PERMISSION);
    }

    public static function customerManagement(): self
    {
        return new self(self::CUSTOMERS_MANAGEMENT_PERMISSION);
    }

    public static function marketingManagement(): self
    {
        return new self(self::MARKETING_MANAGEMENT_PERMISSION);
    }

    public static function salesManagement(): self
    {
        return new self(self::SALES_MANAGEMENT_PERMISSION);
    }

    public static function unserialize(string $serialized): self
    {
        return new self($serialized);
    }

    public function __construct(string $type)
    {
        Assert::oneOf(
            $type,
            [
                self::CATALOG_MANAGEMENT_PERMISSION,
                self::CONFIGURATION_PERMISSION,
                self::CUSTOMERS_MANAGEMENT_PERMISSION,
                self::MARKETING_MANAGEMENT_PERMISSION,
                self::SALES_MANAGEMENT_PERMISSION,
            ]
        );

        $this->type = $type;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function serialize(): string
    {
        return $this->type();
    }

    public function equals(Permission $permission): bool
    {
        return $permission->type() === $this->type();
    }
}
