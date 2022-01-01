<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\SourceCodeElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Flow;
use Phpactor\Flow\Util\NodeBridge;

class SourceCodeResolver implements ElementResolver
{
    public function resolve(Flow $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof SourceFileNode);
        $statements = [];
        foreach ($node->statementList as $statement) {
            $statements[] = $interpreter->interpret($frame, $statement);
        }

        return new SourceCodeElement(NodeBridge::rangeFromNode($node), $statements);
    }
}
