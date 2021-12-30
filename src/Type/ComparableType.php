<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

abstract class ComparableType implements Type
{
    abstract public function value(): mixed;

    public function strictEquals(Type $type): bool
    {
        if (!$type instanceof ComparableType) {
            return false;
        }

        return $type->value() === $this->value();
    }

    public function strictUnequals(Type $type): bool
    {
        if (!$type instanceof ComparableType) {
            return false;
        }

        return $type->value() !== $this->value();
    }


    public function negate(): bool
    {
        return !$this->value();
    }

    public function add(ComparableType $rightType): ComparableType
    {
        return $this;
    }
}
