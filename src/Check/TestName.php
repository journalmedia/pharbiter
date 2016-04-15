<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Check;

class TestName
{
    public static function fromString(string $value): TestName
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
