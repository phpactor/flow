<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\ParenthesizedExpression;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ParenthesizedExpressionElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Util\NodeBridge;

class ParenthesizedExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ParenthesizedExpression);

        $info = $interpreter->interpret($frame, $node->expression);

        return NodeInfo::fromNode($node, $info->type());
    }
}
