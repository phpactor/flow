<?php

namespace Phpactor\Flow\Element;

use Generator;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor\Flow\Element;
use Phpactor\Flow\Range;

class ClassDeclarationElement extends Element
{
    public function __construct(private Range $range)
    {
    }
    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [];
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
