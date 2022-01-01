<?php

namespace Phpactor\Flow;

use IteratorAggregate;
use Traversable;

class Types implements IteratorAggregate
{
    public function __construct(private array $types) {
    }

    public function getIterator(): Traversable
    {
        return new IteratorAggregate($this->types);
    }

    public function firstOrNull(): ?Type
    {
        if (isset($this->types[0])) {
            return $this->types[0];
        }

        return null;
    }
}
