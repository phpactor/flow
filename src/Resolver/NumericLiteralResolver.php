<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\NumericLiteral;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ScalarElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type\IntegerType;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\TextDocument\ByteOffsetRange;

class NumericLiteralResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof NumericLiteral);
        $type = new IntegerType(intval($node->getText()));

        return new ScalarElement(NodeBridge::rangeFromNode($node), $type);
    }
}
