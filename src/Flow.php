<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\NamespaceDefinitionElement;
use Phpactor\Flow\Element\UnmanagedElement;
use Phpactor\Flow\Evaluator\GetClassEvaluator;
use Phpactor\Flow\Reflection\ReflectionClass;
use Phpactor\Flow\Util\DebugHelper;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\ByteOffsetRange;
use RuntimeException;

class Flow
{
    /**
     * @param ElementResolver[] $resolvers
     */
    public function __construct(
        private readonly array $resolvers = []
    )
    {
    }

    public function interpret(Frame $frame, Node $node): Element
    {
        if (isset($this->resolvers[$node::class])) {
            return $this->resolvers[$node::class]->resolve($this, $frame, $node);
        }

        if (DebugHelper::isDebug()) {
            throw new RuntimeException(sprintf(
                'Do not know how to handle node of type "%s"',
                get_class($node)
            ));
        }

        return new UnmanagedElement(
            get_class($node),
            NodeBridge::rangeFromNode($node),
            array_map(function (Node $node) use ($frame) {
                return $this->interpret($frame, $node);
            }, iterator_to_array($node->getChildNodes()))
        );
    }
}
