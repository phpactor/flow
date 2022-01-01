<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\NumericLiteral;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\ScalarElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Flow;
use Phpactor\Flow\Type\FloatType;
use Phpactor\Flow\Type\IntegerType;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\TextDocument\ByteOffsetRange;

class ClassDeclarationResolver implements ElementResolver
{
    public function resolve(Flow $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof NumericLiteral);

        return new ClassDeclarationElement(NodeBridge::rangeFromNode($node));
    }
}
