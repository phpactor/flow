<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Microsoft\PhpParser\Node\Expression\UnaryOpExpression;
use Microsoft\PhpParser\Node\ReservedWord;
use Microsoft\PhpParser\Node\SourceFileNode;
use Microsoft\PhpParser\Node\Statement\InlineHtml;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor\Flow\Element\UnmanagedElement;
use Phpactor\Flow\Resolver\BinaryExpressionResolver;
use Phpactor\Flow\Resolver\InlineHtmlResolver;
use Phpactor\Flow\Resolver\ReservedWordResolver;
use Phpactor\Flow\Resolver\ReturnStatementResolver;
use Phpactor\Flow\Resolver\SourceCodeResolver;
use Phpactor\Flow\Resolver\UnaryOpResolver;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\TextDocument\ByteOffsetRange;
use RuntimeException;

class Interpreter
{
    public function __construct(private readonly array $resolvers = [], private bool $development = false)
    {
    }

    public static function create(): self
    {
        return new self([
            SourceFileNode::class => new SourceCodeResolver(),
            ReturnStatement::class => new ReturnStatementResolver(),
            BinaryExpression::class => new BinaryExpressionResolver(),
            ReservedWord::class => new ReservedWordResolver(),
            UnaryOpExpression::class => new UnaryOpResolver(),
            InlineHtml::class => new InlineHtmlResolver(),
        ]);
    }

    /**
     * @template T
     * @param class-string<T> $class
     * @return T
     */
    public function interpretClass(Node $node, string $class): Element
    {
        $element = $this->interpret($node);
        if (!$element instanceof $class) {
            throw new RuntimeException(sprintf(
                'Expected element class of type "%s", but got "%s"',
                $class, get_class($element)
            ));
        }

        return $element;
    }

    public function interpret(Node $node): Element
    {
        if (isset($this->resolvers[$node::class])) {
            return $this->resolvers[$node::class]->resolve($this, $node);
        }

        if (!$this->development) {
            throw new RuntimeException(sprintf(
                'Do not know how to handle node of type "%s"',
                get_class($node)
            ));
        }

        return new UnmanagedElement(
            get_class($node),
            NodeBridge::rangeFromNode($node),
            array_map(function (Node $node) {
                return $this->interpret($node);
            }, iterator_to_array($node->getChildNodes()))
        );
    }
}
