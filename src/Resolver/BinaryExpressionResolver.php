<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\BinaryExpressionElement;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type\BooleanType;
use Phpactor\Flow\Type\ComparableType;
use Phpactor\Flow\Type\UndefinedType;
use Phpactor\Flow\Util\NodeBridge;

class BinaryExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Node $node): Element
    {
        assert($node instanceof BinaryExpression);
        $left = $interpreter->interpret($node->leftOperand);
        $right = $interpreter->interpret($node->rightOperand);

        $value = match ($node->operator->getText($node->getFileContents())) {
            '===' => $left->type()->strictEquals($right->type()),
            '!==' => $left->type()->strictUnequals($right->type()),
            default => new UndefinedType(),
        };

        return new BinaryExpressionElement(
            NodeBridge::rangeFromNode($node),
            $left,
            $right,
            new BooleanType($value),
        );
    }
}
