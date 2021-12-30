<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Type;
use Phpactor\TextDocument\ByteOffsetRange;

class BinaryExpressionElement extends Element
{
    public function __construct(
        private ByteOffsetRange $range,
        private Element $left,
        private Element $right,
        private Type $type,
    )
    {
    }

    public function left(): Element
    {
        return $this->left;
    }

    public function right(): Element
    {
        return $this->right;
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [
            $this->left,
            $this->right,
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
