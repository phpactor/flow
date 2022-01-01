<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression;
use Microsoft\PhpParser\Node\Expression\CallExpression;
use Microsoft\PhpParser\Node\QualifiedName;
use Microsoft\PhpParser\SomeNode;
use Microsoft\PhpParser\Token;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\CallExpressionElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\StringType;
use Phpactor\Flow\Util\NodeBridge;

class CallExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof CallExpression);

        $arguments = array_map(fn(Node $expr) => $interpreter->interpret(
            $frame,
            $expr
        ), array_filter(iterator_to_array($node->argumentExpressionList?->getElements()) ?? [], fn (Token|Node $n) => $n instanceof Node));
        $type = $this->resolveType($node->callableExpression, $arguments);

        return new CallExpressionElement(NodeBridge::rangeFromNode($node), $type);
    }

    private function resolveType(QualifiedName|Expression $expression, array $arguments): Type
    {
        if ($expression instanceof QualifiedName) {
            return $this->resolveFunction((string)$expression, $arguments);
        }
    }

    private function resolveFunction(string $functionName, $arguments): Type
    {
        if ($functionName === 'get_class') {
            $type =$arguments[0]->type();
            if ($type instanceof ClassType) {
                return new StringType($type->fqn());
            }
        }

        return new InvalidType();
    }
}