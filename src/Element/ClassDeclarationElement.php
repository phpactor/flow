<?php

namespace Phpactor\Flow\Element;

use Generator;
use Phpactor\Flow\Element;
use Phpactor\Flow\Range;

class ClassDeclarationElement extends Element
{
    /**
     * @param Element[] $members
     */
    public function __construct(private Range $range, private array $members)
    {
    }
    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return $this->members;
    }

    public function range(): Range
    {
        return $this->range;
    }

    /**
     * @template C
     * @param class-string<C> $class
     * @return Generator<C>
     */
    public function childrenByClass(string $class): Generator
    {
        foreach ($this->children() as $child) {
            if ($child instanceof $class) {
                yield $child;
            }
        }
    }
}
