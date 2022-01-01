<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\BinaryExpressionElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type\BooleanType;
use Phpactor\Flow\Type\ComparableType;
use Phpactor\Flow\Type\IntegerType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\UndefinedType;
use Phpactor\Flow\Util\DebugHelper;
use Phpactor\Flow\Util\NodeBridge;
use RuntimeException;
use UnhandledMatchError;

class BinaryExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof BinaryExpression);
        $left = $interpreter->interpret($frame, $node->leftOperand);
        $right = $interpreter->interpret($frame, $node->rightOperand);
        $leftType = $left->type();
        $rightType = $right->type();

        // TODO: All types should have all methods, merge ComparableType into
        //       abstract Type class
        assert($leftType instanceof ComparableType);
        assert($rightType instanceof ComparableType);

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
                'Unknown operator "%s"', $condition
            )) : new InvalidType()
        };

        return new BinaryExpressionElement(
            NodeBridge::rangeFromNode($node),
            $left,
            NodeBridge::token($node->operator),
            $right,
            $type,
        );
    }
}
