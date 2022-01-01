<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Microsoft\PhpParser\Node\Expression\CallExpression;
use Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Microsoft\PhpParser\Node\Expression\ParenthesizedExpression;
use Microsoft\PhpParser\Node\Expression\UnaryOpExpression;
use Microsoft\PhpParser\Node\Expression\Variable;
use Microsoft\PhpParser\Node\NumericLiteral;
use Microsoft\PhpParser\Node\ReservedWord;
use Microsoft\PhpParser\Node\SourceFileNode;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Microsoft\PhpParser\Node\Statement\ExpressionStatement;
use Microsoft\PhpParser\Node\Statement\InlineHtml;
use Microsoft\PhpParser\Node\Statement\NamespaceDefinition;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Microsoft\PhpParser\Node\StringLiteral;
use Phpactor\Flow\Element\NamespaceDefinitionElement;
use Phpactor\Flow\Element\UnmanagedElement;
use Phpactor\Flow\Evaluator\GetClassEvaluator;
use Phpactor\Flow\Reflection\ReflectionClass;
use Phpactor\Flow\Resolver\ArgumentExpressionResolver;
use Phpactor\Flow\Resolver\AssignmentExpressionResolver;
use Phpactor\Flow\Resolver\BinaryExpressionResolver;
use Phpactor\Flow\Resolver\CallExpressionResolver;
use Phpactor\Flow\Resolver\ClassDeclarationResolver;
use Phpactor\Flow\Resolver\ExpressionStatementResolver;
use Phpactor\Flow\Resolver\InlineHtmlResolver;
use Phpactor\Flow\Resolver\NamespaceDefinitionResolver;
use Phpactor\Flow\Resolver\NumericLiteralResolver;
use Phpactor\Flow\Resolver\ObjectCreationExpressionResolver;
use Phpactor\Flow\Resolver\ParenthesizedExpressionResolver;
use Phpactor\Flow\Resolver\ReservedWordResolver;
use Phpactor\Flow\Resolver\ReturnStatementResolver;
use Phpactor\Flow\Resolver\SourceCodeResolver;
use Phpactor\Flow\Resolver\StringLiteralResolver;
use Phpactor\Flow\Resolver\UnaryOpResolver;
use Phpactor\Flow\Resolver\VariableResolver;
use Phpactor\Flow\Util\DebugHelper;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\ByteOffsetRange;
use RuntimeException;

class Interpreter
{
    public function __construct(private readonly array $resolvers = [])
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
            ExpressionStatement::class => new ExpressionStatementResolver(),
            AssignmentExpression::class => new AssignmentExpressionResolver(),
            Variable::class => new VariableResolver(),
            NumericLiteral::class => new NumericLiteralResolver(),
            ParenthesizedExpression::class => new ParenthesizedExpressionResolver(),
            ClassDeclaration::class => new ClassDeclarationResolver(),
            ObjectCreationExpression::Class => new ObjectCreationExpressionResolver(),
            CallExpression::class => new CallExpressionResolver(
                new FunctionEvaluator([
                    'get_class' => new GetClassEvaluator(),
                ])
            ),
            StringLiteral::class => new StringLiteralResolver(),
            ArgumentExpression::class => new ArgumentExpressionResolver(),
            NamespaceDefinition::class => new NamespaceDefinitionResolver(),
        ]);
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
            array_map(function (Node $node) {
                return $this->interpret($frame, $node);
            }, iterator_to_array($node->getChildNodes()))
        );
    }

    public function reflectClass(FullyQualifiedName $fullyQualifiedName): ReflectionClass
    {
        return new ReflectionClass();
    }
}
