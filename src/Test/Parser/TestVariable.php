<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test\Parser;

use Illuminate\Support\Collection;
use JournalMedia\Pharbiter\Test\ProphecyAssignment;
use PhpParser\Node\Expr\Variable;

class TestVariable implements TestNode
{
    public static function fromVariable(Variable $wrappedVariable)
    {
        return new self($wrappedVariable);
    }

    /** @var Variable */
    private $wrappedVariable;

    private function __construct(Variable $wrappedVariable)
    {
        $this->wrappedVariable = $wrappedVariable;
    }

    public function isCallOnAProphecy(Collection $prophecyAssignments): bool
    {
        return $prophecyAssignments->contains(function ($key, ProphecyAssignment $prophecyAssignment) {
            return $prophecyAssignment->getVariableName() === $this->wrappedVariable->name;
        });
    }

    public function getRootVariable(): Variable
    {
        return $this->wrappedVariable;
    }
}
