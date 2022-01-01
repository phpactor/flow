<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\InvalidType;

class ArgumentExpressionElement extends Element
{
    public function __construct(private Range $range, private ?Element $expression)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [];
    }

    public function range(): Range
    {
        return $this->range;
    }

    public function type(): Type
    {
        return $this->expression?->type() ?? new InvalidType('No expression');
    }
}
