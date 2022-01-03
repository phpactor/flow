<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;
use Phpactor\Flow\Types;

final class UnionType extends Type
{
    public function __construct(private Types $types)
    {
    }

    public function strictEquals(Type $type): BooleanType
    {
        foreach ($this->types() as $subType) {
            // @phpstan-ignore-next-line
            if ($type->strictEquals($subType)) {
                return new BooleanType(true);
            }
        }

        return new BooleanType(false);
    }

    public function types(): Types
    {
        return $this->types;
    }
}
