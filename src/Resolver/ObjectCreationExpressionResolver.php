<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Microsoft\PhpParser\Node\Expression\Variable;
use Microsoft\PhpParser\Node\QualifiedName;
use Microsoft\PhpParser\SomeNode;
use Microsoft\PhpParser\Token;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ObjectCreationExpressionElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\MixedType;
use Phpactor\Flow\Type\UnresolvedType;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\Name\FullyQualifiedName;

class ObjectCreationExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ObjectCreationExpression);

        return new ObjectCreationExpressionElement(
            NodeBridge::rangeFromNode($node),
            $this->resolveType($frame, $node->classTypeDesignator)
        );
    }

    private function resolveType(Frame $frame, QualifiedName|Variable|Token $node): Type
    {
        if ($node instanceof QualifiedName) {
            return new ClassType(FullyQualifiedName::fromString((string)$node->getResolvedName()));
        }

        if ($node instanceof Variable) {
            return $frame->getVariable($node->getName()) ?? new MixedType();
        }

        return new UnresolvedType(sprintf(
            'Could not resolve object creation expression with node type "%s"',
            get_class($node)
        ));
    }
}
