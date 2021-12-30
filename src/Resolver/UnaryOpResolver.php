<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\UnaryOpExpression;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\UnaryOpElement;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type\BooleanType;
use Phpactor\Flow\Type\UndefinedType;
use Phpactor\Flow\Util\NodeBridge;

class UnaryOpResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Node $node): Element
    {
        assert($node instanceof UnaryOpExpression);
        $operand = $interpreter->interpret($node->operand);
        $value = match ($node->operator->getText($node->getFileContents())) {
            '!' => $operand->type()->negate(),
            default => new UndefinedType()
        };

        return new UnaryOpElement(NodeBridge::rangeFromNode($node), $operand, new BooleanType($value));
    }
}
