<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Type;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\ByteOffsetRange;

class UnaryOpElement extends Element
{
    private ByteOffsetRange $range;
    private Element $operand;
    private Type $type;

    public function __construct(ByteOffsetRange $range, Element $operand, Type $type)
    {
        $this->range = $range;
        $this->operand = $operand;
        $this->type = $type;
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

    public function range(): ByteOffsetRange
    {
        return $this->rannge;
    }
}
