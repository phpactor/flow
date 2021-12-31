<?php

namespace Phpactor\Flow;

class Token extends Element
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
}
