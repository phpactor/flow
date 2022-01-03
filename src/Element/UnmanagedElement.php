<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;

class UnmanagedElement extends Element
{
    /**
     * @param Element[] $children
     */
    public function __construct(
        public readonly string $nodeType,
        private Range $range,
        private array $children
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return $this->children;
    }

    public function range(): Range
    {
        return $this->range;
    }
}
