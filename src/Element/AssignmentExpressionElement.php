<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\TextDocument\ByteOffsetRange;

class AssignmentExpressionElement extends Element
{
    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
    }

    public function range(): ByteOffsetRange
    {
    }
}
