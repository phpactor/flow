<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

abstract class ComparableType implements Type
{
    abstract public function value(): mixed;

    public function strictEquals(Type $type): BooleanType
    {
        if (!$type instanceof ComparableType) {
            return false;
        }

        return new BooleanType($type->value() === $this->value());
    }

    public function strictUnequals(Type $type): BooleanType
    {
        if (!$type instanceof ComparableType) {
            return false;
        }

        return new BooleanType($type->value() !== $this->value());
    }


    public function negate(): bool
    {
        return !$this->value();
    }

    public function add(ComparableType $type): static
    {
        return $this;
    }

    public function subtract(ComparableType $type): static
    {
        return $this;
    }

    public function divide(Type $type): static
    {
        return $this;
    }

    public function modulo(Type $type): static
    {
        return $this;
    }

    public function pow(Type $type): static
    {
        return $this;
    }

    public function multiply(ComparableType $type): static
    {
        return $this;
    }
}
