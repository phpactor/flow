<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Range;

class UnmanagedElement
{
    public function __construct(public readonly string $nodeType, public readonly Range $range)
    {
    }
}
