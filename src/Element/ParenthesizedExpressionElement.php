<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Type;
use Phpactor\TextDocument\ByteOffsetRange;

class ParenthesizedExpressionElement extends Element
{
    public function __construct(private ByteOffsetRange $ragne, private Element $expression, private Type $type)
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

    public function type(): Type
    {
        return $this->type;
    }
}
