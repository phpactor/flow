<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

/**
 * @template T of number
 */
abstract class NumericType extends Type
{
    /**
     * @param T $value
     */
    final public function __construct(protected null|int|float $value)
    {
    }

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

    public function multiply(Type $type): static
    {
        if (!$type instanceof NumericType) {
            return $this;
        }

        return new static($this->value() * $type->value());
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
