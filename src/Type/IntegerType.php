<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;
use Phpactor\TextDocument\ByteOffsetRange;

final class IntegerType extends ComparableType
{
    public function __construct(private ?int $value)
    {
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function add(Type $type): IntegerType
    {
        if (!$type instanceof IntegerType) {
            return $this;
        }

        return new self($this->value() + $type->value());
    }
}
