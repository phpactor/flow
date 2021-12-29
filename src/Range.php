<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Token;

final class Range
{
    public function __construct(
        public Offset $start,
        public Offset $end,
    )
    {
    }

    public static function fromNodeOrToken(Node|Token $node): self
    {
        return new self($node->getStartPosition(), $node->getEndPosition());
    }
}
