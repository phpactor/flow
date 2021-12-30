<?php

namespace Phpactor\Flow\Type;

final class FloatType extends NumericType
{
    public function __construct(private ?float $value) {
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
