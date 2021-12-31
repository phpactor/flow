<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

class ScalarElement extends Element
{
    public function __construct(private Range $range, private Type $type)
    {
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
        return [];
    }

    public function range(): Range
    {
        return $this->range;
    }
}
