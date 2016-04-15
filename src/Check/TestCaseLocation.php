<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Check;

class TestCaseLocation
{
    public static function fromString(string $value): TestCaseLocation
    {
        return new self;
    }
}
