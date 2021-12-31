<?php

namespace Phpactor\Flow\Util;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Token;
use Phpactor\Flow\Range;
use Phpactor\Flow\Token as PhpactorToken;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\ByteOffsetRange;

class NodeBridge
{
    public static function rangeFromNode(Node $node): Range
    {
        return new Range(
            ByteOffset::fromInt($node->getFullStartPosition()),
            ByteOffset::fromInt($node->getStartPosition()),
            ByteOffset::fromInt($node->getEndPosition())
        );
    }

    public static function token(Token $token): PhpactorToken
    {
        return new PhpactorToken(
            new Range(
                ByteOffset::fromInt($token->getFullStartPosition()),
                ByteOffset::fromInt($token->getStartPosition()),
                ByteOffset::fromInt($token->getEndPosition())
            )
        );
    }
}
