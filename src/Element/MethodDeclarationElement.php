<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

class MethodDeclarationElement extends Element
{
    public function __construct(private Range $range)
    {
    }

    public function name(): string
    {
        return '';
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
}
