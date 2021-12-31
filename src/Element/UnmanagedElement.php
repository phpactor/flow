<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\UndefinedType;

class UnmanagedElement extends Element
{
    public function __construct(
        private string $nodeType,
        private Range $range,
        private array $children
    )
    {
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
