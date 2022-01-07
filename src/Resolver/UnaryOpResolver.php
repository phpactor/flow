<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\UnaryOpExpression;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\UnaryOpElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Type\BooleanType;
use Phpactor\Flow\Util\NodeBridge;

class UnaryOpResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof UnaryOpExpression);
        $operand = $interpreter->interpret($frame, $node->operand);
        $value = match ($node->operator->getText($node->getFileContents())) {
            '!' => $operand->type()->negate(),
            default => null
        };

        return NodeInfo::fromNode($node, new BooleanType($value));
    }
}
