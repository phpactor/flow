<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\BinaryExpressionElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Util\DebugHelper;
use Phpactor\Flow\Util\NodeBridge;
use RuntimeException;

class BinaryExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof BinaryExpression);
        $left = $interpreter->interpret($frame, $node->leftOperand);
        $right = $interpreter->interpret($frame, $node->rightOperand);
        $leftType = $left->type();
        $rightType = $right->type();

        $condition = $node->operator->getText($node->getFileContents());
        $type = match ($condition) {
            '===' => $leftType->strictEquals($rightType),
            '!==' => $leftType->strictUnequals($rightType),
            '+' => $leftType->add($rightType),
            '-' => $leftType->subtract($rightType),
            '*' => $leftType->multiply($rightType),
            '**' => $leftType->pow($rightType),
            '%' => $leftType->modulo($rightType),
            '/' => $leftType->divide($rightType),
            default => DebugHelper::isDebug() ? throw new RuntimeException(sprintf(
                'Unknown operator "%s"',
                $condition
            )) : new InvalidType(sprintf('Unknown operator "%s"', $condition))
        };

        return NodeInfo::fromNode($node, $type);
    }
}
