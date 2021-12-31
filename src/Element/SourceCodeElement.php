<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;

final class SourceCodeElement extends Element
{
    public function __construct(
        public Range $range,
        public array $statements
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return $this->statements;
    }

    public function parent(): ?Element
    {
        return null;
    }

    public function range(): Range
    {
        return $this->range;
    }
}
