<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Type\BooleanType;
use Phpactor\Flow\Type\UnionType;

abstract class Type
{
    public function value(): mixed
    {
        return null;
    }

    public function strictEquals(Type $type): BooleanType
    {
        if ($type instanceof UnionType) {
            foreach ($type->types() as $subType) {
                // @phpstan-ignore-next-line
                if ($this->strictEquals($subType)) {
                    return new BooleanType(true);
                }
            }
            return new BooleanType(false);
        }

        return new BooleanType($type->value() === $this->value());
    }

    public function strictUnequals(Type $type): BooleanType
    {
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
