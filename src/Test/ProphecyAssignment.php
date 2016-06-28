<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test;

use PhpParser\Node\Expr\Assign;

class ProphecyAssignment
{
    public static function fromAssign(Assign $node)
    {
        return new self($node->var->name, $node->expr->args[0]->value->value);
    }

    /** @var string */
    private $variableName;

    /** @var string */
    private $prophesizedClassName;

    private function __construct(string $variableName, string $prophesizedClassName)
    {
        $this->variableName = $variableName;
        $this->prophesizedClassName = $prophesizedClassName;
    }

    public function getVariableName(): string
    {
        return $this->variableName;
    }

    public function getProphesizedClassName(): string
    {
        return $this->prophesizedClassName;
    }
}
