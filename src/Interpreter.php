<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Phpactor\DocblockParser\Ast\Docblock;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\UnmanagedElement;
use Phpactor\Flow\Reflection\ReflectionClass;
use Phpactor\Flow\Util\DebugHelper;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\Name\FullyQualifiedName;
use RuntimeException;

class Interpreter
{
    /**
     * @param ElementResolver[] $resolvers
     */
    public function __construct(
        private AstLocator $locator,
        private DocblockFactory $docblockFactory,
        private readonly array $resolvers = []
    ) {
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

    /**
     * @template TClass of Element
     * @param class-string<TClass> $class
     * @return TClass
     */
    public function interpretClass(Frame $frame, Node $node, string $class): Element
    {
        $element = $this->interpret($frame, $node);
        if (!$element instanceof $class) {
            throw new RuntimeException(sprintf(
                'Expected element of type "%s" but got "%s"',
                $class,
                get_class($element)
            ));
        }

        return $element;
    }

    public function reflectClass(FullyQualifiedName $fullyQualifiedName, Types $arguments): ?ReflectionClass
    {
        $node = $this->locator->locate($fullyQualifiedName, SourceLocator::TYPE_CLASS);

        if (null === $node) {
            return null;
        }

        return new ReflectionClass(
            $this->interpretClass(
                new Frame(),
                $node,
                ClassDeclarationElement::class
            ),
            $arguments
        );
    }

    public function docblock(string $docblock): Docblock
    {
        return $this->docblockFactory->create($docblock);
    }
}
