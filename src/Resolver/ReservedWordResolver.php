<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\ReservedWord;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ScalarElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\BooleanType;
use Phpactor\Flow\Type\MixedType;
use Phpactor\Flow\Util\NodeBridge;

class ReservedWordResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof ReservedWord);

        return NodeInfo::fromNode($node, $this->resolveType($node));
    }

    private function resolveType(ReservedWord $node): Type
    {
        if ($node->getText() === 'true') {
            return new BooleanType(true);
        }

        if ($node->getText() === 'false') {
            return new BooleanType(false);
        }

        return new MixedType();
    }
}
