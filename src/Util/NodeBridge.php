<?php

namespace Phpactor\Flow\Util;

use Microsoft\PhpParser\Node;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\ByteOffsetRange;

class NodeBridge
{
    public static function rangeFromNode(Node $node): ByteOffsetRange
    {
        return ByteOffsetRange::fromByteOffsets(
            ByteOffset::fromInt($node->getStartPosition()),
            ByteOffset::fromInt($node->getEndPosition())
        );
    }
}
