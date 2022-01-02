<?php

namespace Phpactor\Flow\Resolver;

use ArrayIterator;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression;
use Microsoft\PhpParser\Node\Expression\CallExpression;
use Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Microsoft\PhpParser\Node\QualifiedName;
use Microsoft\PhpParser\SomeNode;
use Microsoft\PhpParser\Token;
use Phpactor\Flow\ClassReflector;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\CallExpressionElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\FunctionExecutor;
use Phpactor\Flow\Flow;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\StringType;
use Phpactor\Flow\Type\UnresolvedType;
use Phpactor\Flow\Types;
use Phpactor\Flow\Util\NodeBridge;

class CallExpressionResolver implements ElementResolver
{
    public function __construct(private ClassReflector $reflector, private FunctionExecutor $evaluator)
    {
    }
    public function resolve(Flow $flow, Frame $frame, Node $node): Element
    {
        assert($node instanceof CallExpression);

        $arguments = new Types(
            array_map(
                fn(Element $e) => $e->type(),
                array_map(
                    fn(Node $expr) => $flow->interpret($frame, $expr),
                    array_filter(
                        iterator_to_array($node->argumentExpressionList?->getElements() ?? new ArrayIterator([])),
                        fn (Token|Node $n) => $n instanceof Node
                    )
                )
            )
        );

        $type = $this->resolveType($frame, $flow, $node->callableExpression, $arguments);

        return new CallExpressionElement(NodeBridge::rangeFromNode($node), $type);
    }

    private function resolveType(
        Frame $frame,
        Flow $flow,
        QualifiedName|Expression $expression,
        Types $arguments
    ): Type
    {
        if ($expression instanceof QualifiedName) {
            return $this->resolveFunction((string)$expression, $arguments);
        }

        if ($expression instanceof MemberAccessExpression) {
            return $this->resolveMemberAccess($frame, $flow, $expression, $arguments);
        }

        return new UnresolvedType(sprintf('Do not know how to handle call expression of type "%s"', get_class($expression)));
    }

    private function resolveFunction(string $functionName, Types $arguments): Type
    {
        return $this->evaluator->evaluate($functionName, $arguments);
    }

    private function resolveMemberAccess(Frame $frame, Flow $flow, MemberAccessExpression $expression, Types $arguments): Type
    {
        /** @phpstan-ignore-next-line */
        $name = $expression?->memberName->getText($expression->getFileContents());
        $dereferencable = $flow->interpret($frame, $expression->dereferencableExpression);
        $dereferenableType = $dereferencable->type();

        if (!$dereferenableType instanceof ClassType) {
            return new InvalidType(sprintf(
                'Method call on non-class type "%s"', get_class($dereferenableType)
            ));
        }

        $class = $this->reflector->reflectClass($dereferenableType->fqn());
        $member = $class->methods()->get((string)$name);

        if (null === $member) {
            return new InvalidType(sprintf(
                'Method "%s" does not exist on class "%s"',
                $name, (string)$class->name()
            ));
        }

        return $member->type();
    }
}
