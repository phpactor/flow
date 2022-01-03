<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

class UnaryOpElement extends Element
{
    public function __construct(
        private Range $range,
        private Element $operand,
        private Type $type
    ) {
    }

    public function type(): Type
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [
            $this->operand,
        ];
    }

    public function range(): Range
    {
        return $this->range;
    }
}
