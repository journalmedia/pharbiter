<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test\Parser;

use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Variable;

interface TestNode
{
    public function isCallOnAProphecy(Collection $prophecyAssignments): bool;
    public function getRootVariable(): Variable;
}
