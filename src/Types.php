<?php

namespace Phpactor\Flow;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int,Type>
 */
class Types implements IteratorAggregate
{
    /**
     * @param array<int,Type> $types
     */
    public function __construct(private array $types) {
    }

    /**
     * @return ArrayIterator<int,Type>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->types);
    }

    public function firstOrNull(): ?Type
    {
        if (isset($this->types[0])) {
            return $this->types[0];
        }

        return null;
    }
}
