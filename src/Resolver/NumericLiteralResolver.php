<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\NumericLiteral;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ScalarElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Flow;
use Phpactor\Flow\Type\FloatType;
use Phpactor\Flow\Type\IntegerType;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\TextDocument\ByteOffsetRange;

class NumericLiteralResolver implements ElementResolver
{
    public function resolve(Flow $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof NumericLiteral);

        return new ScalarElement(NodeBridge::rangeFromNode($node), $this->parseNumber($node->getText()));
    }

    private function parseNumber(string $number): FloatType|IntegerType
    {
        if (false !== strpos($number, '.')) {
            return new FloatType(floatval($number));
        }

        return new IntegerType(intval($number));
    }
}
