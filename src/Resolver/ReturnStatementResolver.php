<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ReturnStatementElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Util\NodeBridge;

final class ReturnStatementResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ReturnStatement);

        return new ReturnStatementElement(
            NodeBridge::rangeFromNode($node),
            $interpreter->interpret($frame, $node->expression)
        );
    }
}
