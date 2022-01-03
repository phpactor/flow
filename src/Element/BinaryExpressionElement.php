<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Token;
use Phpactor\Flow\Type;

class BinaryExpressionElement extends Element
{
    public function __construct(
        private Range $range,
        private Element $left,
        private Token $operator,
        private Element $right,
        private Type $type,
    ) {
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
            $this->operator,
            $this->right,
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
