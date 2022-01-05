<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor\DocblockParser\Ast\Tag\MethodTag;
use Phpactor\DocblockParser\Ast\Tag\ReturnTag;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\ClassMembersElement;
use Phpactor\Flow\Element\DocblockElement;
use Phpactor\Flow\Element\UnmanagedElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Range;
use Phpactor\Flow\Util\DocblockBridge;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\TextDocument\ByteOffset;

class ClassDeclarationResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ClassDeclaration);

        $memberElements = [];

        $docblock = $interpreter->docblock($node->getLeadingCommentAndWhitespaceText());

        $docblockMembers = [];
        $prev = null;
        foreach ($docblock->descendantElements() as $method) {
            if ($method instanceof MethodTag) {
                $docblockMembers[] = DocblockBridge::element(
                    $node,
                    $prev ? $prev->start() - 1 : 0,
                    $method
                );
            }
            $prev = $method;
        }

        $docblockEement = new DocblockElement(new Range(
            ByteOffset::fromInt($node->getFullStartPosition()),
            ByteOffset::fromInt($node->getFullStartPosition() + $docblock->start()),
            ByteOffset::fromInt($node->getStartPosition()),
        ), $docblockMembers);

        return new ClassDeclarationElement(
            NodeBridge::rangeFromNode($node),
            $docblockEement,
            NodeBridge::token($node->abstractOrFinalModifier, $node->getStartPosition()),
            NodeBridge::token($node->classKeyword, $node->getStartPosition()),
            NodeBridge::token($node->name),
            $interpreter->interpretClass($frame, $node->classMembers, ClassMembersElement::class)
        );
    }
}
