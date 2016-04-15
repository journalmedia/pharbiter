<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Check;

class TestName
{
    public static function fromString(string $value): TestName
    {
        return new self;
    }
}
