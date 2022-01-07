<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;

class ArgumentExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof ArgumentExpression);
        $expression = $interpreter->interpret($frame, $node->expression);

        return NodeInfo::fromNode($node, $expression->type());
    }
}
