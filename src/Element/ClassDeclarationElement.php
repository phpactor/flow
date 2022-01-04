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
    public function __construct(
        private Range $range,
        private DocblockElement $docblock,
        private array $members
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return array_merge([$this->docblock], $this->members);
    }

    public function range(): Range
    {
        return $this->range;
    }

    public function docblock(): DocblockElement
    {
        return $this->docblock;
    }
}
