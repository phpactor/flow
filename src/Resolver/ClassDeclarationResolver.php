<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\ClassMembersNode;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Microsoft\PhpParser\Node\NumericLiteral;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\MethodDeclarationElement;
use Phpactor\Flow\Element\ScalarElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type\FloatType;
use Phpactor\Flow\Type\IntegerType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\TextDocument\ByteOffsetRange;

class ClassDeclarationResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ClassDeclaration);

        $memberElements = [];
        /** @phpstan-ignore-next-line */
        foreach ($node?->classMembers?->classMemberDeclarations ?? [] as $member) {
            $memberElements[] = $interpreter->interpret($frame, $member);
        }

        return new ClassDeclarationElement(
            NodeBridge::rangeFromNode($node),
            $memberElements
        );
    }
}
