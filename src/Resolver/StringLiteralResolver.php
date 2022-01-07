<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\StringLiteral;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ScalarElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Type\StringType;
use Phpactor\Flow\Util\NodeBridge;

class StringLiteralResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof StringLiteral);

        return NodeInfo::fromNode($node, new StringType($node->getStringContentsText()));
    }
}
