<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Model;

use Webmozart\Assert\Assert;

final class OperationType
{
    public const READ = 'read';
    public const WRITE = 'write';

    /** @var string */
    private $type;

    /** @var OperationType */
    private static $readOperationType;

    /** @var OperationType */
    private static $writeOperationType;

    public static function read(): self
    {
        if (null === self::$readOperationType) {
            self::$readOperationType = new self(self::READ);
        }

        return self::$readOperationType;
    }

    public static function write(): self
    {
        if (null === self::$writeOperationType) {
            self::$writeOperationType = new self(self::WRITE);
        }

        return self::$writeOperationType;
    }

    public function __construct(string $type)
    {
        Assert::oneOf($type, [self::READ, self::WRITE]);

        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
