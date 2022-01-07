<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
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
        private readonly array $resolvers,
        private NodeTable $table
    ) {
    }

    public function interpretNoFrame(Node $node): NodeInfo
    {
        return $this->interpret(new Frame(), $node);
    }

    public function interpret(Frame $frame, Node $node): NodeInfo
    {
        if (isset($this->resolvers[$node::class])) {
            $info = $this->resolvers[$node::class]->resolve($this, $frame, $node);
            $this->table->setInfo($node, $info);
            return $info;
        }

        if (DebugHelper::isDebug()) {
            throw new RuntimeException(sprintf(
                'Do not know how to handle node of type "%s"',
                get_class($node)
            ));
        }

        return NodeInfo::fromNode($node);
    }

    public function reflectClass(FullyQualifiedName $fullyQualifiedName, Types $arguments): ?ReflectionClass
    {
        $node = $this->locator->locate($fullyQualifiedName, SourceLocator::TYPE_CLASS);

        if (!$node instanceof ClassDeclaration) {
            return null;
        }

        return new ReflectionClass(
            $this,
            $node,
            $arguments
        );
    }

    public function docblock(string $docblock): Docblock
    {
        return $this->docblockFactory->create($docblock);
    }
}
