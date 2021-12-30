<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Type;
use Phpactor\TextDocument\ByteOffsetRange;

class ScalarElement extends Element
{
    public function __construct(private ByteOffsetRange $range, private Type $type)
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

    public function range(): ByteOffsetRange
    {
        return $this->range;
    }
}
