<?php

namespace Phpactor\Flow\Element;

use Microsoft\PhpParser\Node;
use Phpactor\Flow\Element;
use Phpactor\Flow\Type;
use Phpactor\TextDocument\ByteOffsetRange;

class ReturnStatementElement extends Element
{
    public function __construct(private ByteOffsetRange $range, private Element $expression)
    {
    }

    public function children(): array
    {
        return [$this->expression];
    }

    public function range(): ByteOffsetRange
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
