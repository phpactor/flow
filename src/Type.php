<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Type\BooleanType;

abstract class Type
{
    public function value(): mixed
    {
        return null;
    }

    public function strictEquals(Type $type): BooleanType
    {
        if (!$type instanceof Type) {
            return $this;
        }

        return new BooleanType($type->value() === $this->value());
    }

    public function strictUnequals(Type $type): BooleanType
    {
        if (!$type instanceof Type) {
            return false;
        }

        return new BooleanType($type->value() !== $this->value());
    }

    public function negate(): bool
    {
        return !$this->value();
    }

    public function add(Type $type): static
    {
        return $this;
    }

    public function subtract(Type $type): static
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

    public function multiply(Type $type): static
    {
        return $this;
    }
}
