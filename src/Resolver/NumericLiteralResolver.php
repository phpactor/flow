<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\NumericLiteral;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Type\FloatType;
use Phpactor\Flow\Type\IntegerType;

class NumericLiteralResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof NumericLiteral);

        return NodeInfo::fromNode($node, $this->parseNumber($node->getText()));
    }

    private function parseNumber(string $number): FloatType|IntegerType
    {
        if (false !== strpos($number, '.')) {
            return new FloatType(floatval($number));
        }

        return new IntegerType(intval($number));
    }
}
