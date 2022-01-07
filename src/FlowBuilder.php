<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node\ClassMembersNode;
use Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Microsoft\PhpParser\Node\Expression\CallExpression;
use Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Microsoft\PhpParser\Node\Expression\ParenthesizedExpression;
use Microsoft\PhpParser\Node\Expression\UnaryOpExpression;
use Microsoft\PhpParser\Node\Expression\Variable;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Microsoft\PhpParser\Node\NumericLiteral;
use Microsoft\PhpParser\Node\ReservedWord;
use Microsoft\PhpParser\Node\SourceFileNode;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Microsoft\PhpParser\Node\Statement\ExpressionStatement;
use Microsoft\PhpParser\Node\Statement\InlineHtml;
use Microsoft\PhpParser\Node\Statement\NamespaceDefinition;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Microsoft\PhpParser\Node\StringLiteral;
use Microsoft\PhpParser\Parser;
use Phpactor\DocblockParser\Lexer;
use Phpactor\DocblockParser\Parser as PhpactorParser;
use Phpactor\Flow\Evaluator\GetClassEvaluator;
use Phpactor\Flow\Resolver\ArgumentExpressionResolver;
use Phpactor\Flow\Resolver\AssignmentExpressionResolver;
use Phpactor\Flow\Resolver\BinaryExpressionResolver;
use Phpactor\Flow\Resolver\CallExpressionResolver;
use Phpactor\Flow\Resolver\ClassDeclarationResolver;
use Phpactor\Flow\Resolver\ClassMembersResolver;
use Phpactor\Flow\Resolver\ExpressionStatementResolver;
use Phpactor\Flow\Resolver\InlineHtmlResolver;
use Phpactor\Flow\Resolver\MethodDeclarationResolver;
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
use Phpactor\Flow\SourceLocator\ChainLocator;
use Phpactor\Flow\SourceLocator\StringLocator;

final class FlowBuilder
{
    /**
     * @var SourceLocator[]
     */
    private $locators = [];

    public function __construct(private Parser $parser)
    {
    }

    public static function create(): FlowBuilder
    {
        return new self(new Parser());
    }

    public function withSource(string $source): self
    {
        $this->locators[] = StringLocator::fromString($source);
        return $this;
    }

    public function build(): Flow
    {
        return new Flow(
            $this->parser,
            $this->createInterpreter()
        );
    }

    private function createInterpreter(): Interpreter
    {
        return new Interpreter(
            $this->createNodeLocator(),
            $this->createDocblockFactory(),
            [
                ReturnStatement::class => new ReturnStatementResolver(),
                BinaryExpression::class => new BinaryExpressionResolver(),
                ReservedWord::class => new ReservedWordResolver(),
                UnaryOpExpression::class => new UnaryOpResolver(),
                AssignmentExpression::class => new AssignmentExpressionResolver(),
                Variable::class => new VariableResolver(),
                NumericLiteral::class => new NumericLiteralResolver(),
                ParenthesizedExpression::class => new ParenthesizedExpressionResolver(),
                ClassDeclaration::class => new ClassDeclarationResolver(),
                ObjectCreationExpression::class => new ObjectCreationExpressionResolver(),
                CallExpression::class => new CallExpressionResolver(
                    new FunctionExecutor([
                        'get_class' => new GetClassEvaluator(),
                    ])
                ),
                StringLiteral::class => new StringLiteralResolver(),
            ],
            new NodeTable()
        );
    }

    private function createNodeLocator(): AstLocator
    {
        return new AstLocator($this->parser, $this->createLocator());
    }

    private function createLocator(): SourceLocator
    {
        return new ChainLocator($this->locators);
    }

    private function createDocblockFactory(): DocblockFactory
    {
        return new DocblockFactory(new Lexer(), new PhpactorParser());
    }
}
