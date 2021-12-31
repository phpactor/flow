<?php

namespace Phpactor\Flow\Element;

use Microsoft\PhpParser\Node;
use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

class ReturnStatementElement extends Element
{
    public function __construct(private Range $range, private Element $expression)
    {
    }

    public function children(): array
    {
        return [$this->expression];
    }

    public function range(): Range
    {
        return $this->range;
    }

    public function expression(): Element
    {
        return $this->expression;
    }

    public function type(): Type
    {
        return $this->expression->type();
    }
}
