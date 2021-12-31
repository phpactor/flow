<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

class ParenthesizedExpressionElement extends Element
{
    public function __construct(private Range $range, private Element $expression, private Type $type)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [
            $this->expression
        ];
    }

    public function range(): Range
    {
        return $this->range;
    }

    public function type(): Type
    {
        return $this->type;
    }
}
