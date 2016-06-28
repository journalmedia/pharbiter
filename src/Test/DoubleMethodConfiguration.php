<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test;

class DoubleMethodConfiguration
{
    public static function fromClassAndMethod(string $className, string $methodName): DoubleMethodConfiguration
    {
        return new self($className, $methodName);
    }

    /** @var string */
    private $className;

    /** @var string */
    private $methodName;

    private function __construct(string $className, string $methodName)
    {
        $this->className = $className;
        $this->methodName = $methodName;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }
}
