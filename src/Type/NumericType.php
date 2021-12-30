<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

abstract class NumericType extends ComparableType
{
    public function add(Type $type): static
    {
        if (!$type instanceof NumericType) {
            return $this;
        }

        return new static($this->value() + $type->value());
    }

    public function subtract(Type $type): static
    {
        if (!$type instanceof NumericType) {
            return $this;
        }

        return new static($this->value() - $type->value());
    }

    public function divide(Type $type): static
    {
        if (!$type instanceof NumericType) {
            return $this;
        }

        return new static($this->value() / $type->value());
    }

    public function modulo(Type $type): static
    {
        if (!$type instanceof NumericType) {
            return $this;
        }

        return new static($this->value() % $type->value());
    }

    public function pow(Type $type): static
    {
        if (!$type instanceof NumericType) {
            return $this;
        }

        return new static($this->value() ** $type->value());
    }
}
