<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test;

use Illuminate\Support\Collection;

class Test
{
    public static function fromDoubles(Collection $doubles): Test
    {
        return new self;
    }
}
