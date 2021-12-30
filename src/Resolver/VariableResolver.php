<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\Variable;
use Microsoft\PhpParser\Node\Statement\InlineHtml;
use Microsoft\PhpParser\Token;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\InlineHtmlElement;
use Phpactor\Flow\Element\VariableElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type\UndefinedType;
use Phpactor\Flow\Util\NodeBridge;
use SebastianBergmann\Type\UnknownType;

class VariableResolver implements ElementResolver
{
    private const UNKNOWN_VARNAME = '__unknown__';

    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof Variable);

        $name = self::UNKNOWN_VARNAME;
        if ($node->name instanceof Token) {
            $name = $node->name->getText($node->getFileContents());
        }

        return new VariableElement(
            NodeBridge::rangeFromNode($node),
            $name,
            $frame->getVariable($name)?->type() ?? new UndefinedType()
        );
    }
}
