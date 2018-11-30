<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Model;

final class Section
{
    public const CATALOG = 'catalog';
    public const CONFIGURATION = 'configuration';
    public const CUSTOMERS = 'customers';
    public const MARKETING = 'marketing';
    public const SALES = 'sales';

    /** @var string */
    private $type;

    public static function catalog(): self
    {
        return new self(self::CATALOG);
    }

    public static function configuration(): self
    {
        return new self(self::CONFIGURATION);
    }

    public static function customers(): self
    {
        return new self(self::CUSTOMERS);
    }

    public static function marketing(): self
    {
        return new self(self::MARKETING);
    }

    public static function sales(): self
    {
        return new self(self::SALES);
    }

    public static function ofType(string $type): self
    {
        return new self($type);
    }

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public function equals(self $section): bool
    {
        return $section->__toString() === $this->__toString();
    }
}
