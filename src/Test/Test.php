<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test;

use Illuminate\Support\Collection;

class Test
{
    public static function fromDoubleMethodConfigurations(Collection $doubleMethodConfigurations): Test
    {
        return new self($doubleMethodConfigurations);
    }

    /** @var Collection */
    private $doubleMethodConfigurations;

    private function __construct(Collection $doubleMethodConfigurations)
    {
        $this->doubleMethodConfigurations = $doubleMethodConfigurations;
    }

    public function getDoubleMethodConfigurations(): Collection
    {
        return $this->doubleMethodConfigurations;
    }
}
