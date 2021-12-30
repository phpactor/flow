<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\TextDocument\ByteOffsetRange;

class ExpressionStatementElement extends Element
{
    public function __construct(private ByteOffsetRange $range, private Element $expression)
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

    public function range(): ByteOffsetRange
    {
        return $this->range;
    }
}
