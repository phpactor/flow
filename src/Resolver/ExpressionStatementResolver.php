<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\ExpressionStatement;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ExpressionStatementElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Util\NodeBridge;

class ExpressionStatementResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ExpressionStatement);
        return new ExpressionStatementElement(
            NodeBridge::rangeFromNode($node),
            $interpreter->interpret($frame, $node->expression)
        );
    }

}
