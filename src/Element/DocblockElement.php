<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;

class DocblockElement extends Element
{
    public function __construct(private Range $range, private array $children) {
    }

    public function children(): array
    {
        return $this->children;
    }

    public function range(): Range
    {
        return $this->range;
    }
}
