<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\InlineHtml;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\InlineHtmlElement;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Util\NodeBridge;

class InlineHtmlResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Node $node): Element
    {
        assert($node instanceof InlineHtml);
        return new InlineHtmlElement(NodeBridge::rangeFromNode($node));
    }
}
