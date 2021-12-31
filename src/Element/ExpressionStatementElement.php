<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;

class ExpressionStatementElement extends Element
{
    public function __construct(private Range $range, private Element $expression)
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
}
