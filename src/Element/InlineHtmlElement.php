<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\TextDocument\ByteOffsetRange;
 
class InlineHtmlElement extends Element
{
    public function __construct(private ByteOffsetRange $range) {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [];
    }

    public function range(): ByteOffsetRange
    {
        return $this->range;
    }
}
