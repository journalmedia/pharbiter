<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Check;

class TestCaseLocation
{
    public static function fromString(string $value): TestCaseLocation
    {
        return new self($value);
    }

    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
