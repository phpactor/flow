<?php

namespace Phpactor\Flow\Util;

use Microsoft\PhpParser\Node;
use Phpactor\DocblockParser\Ast\Element;
use Phpactor\DocblockParser\Ast\Tag\MethodTag;
use Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor\DocblockParser\Ast\Type\ClassNode;
use Phpactor\DocblockParser\Ast\Type\UnionNode;
use Phpactor\Flow\Element as PhpactorElement;
use Phpactor\Flow\Element\MethodDeclarationElement;
use Phpactor\Flow\Element\UnmanagedElement;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\UnionType;
use Phpactor\Flow\Types;
use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\ByteOffset;

final class DocblockBridge
{
    public static function type(Node $node, TypeNode $docType): Type
    {
        if ($docType instanceof UnionNode) {
            return new UnionType(new Types(array_map(
                fn (TypeNode $docType) => self::type($node, $docType),
                iterator_to_array($docType->types->types())
            )));
        }

        if ($docType instanceof ClassNode) {
            return new ClassType(FullyQualifiedName::fromString($docType->toString()));
        }

        return new InvalidType(sprintf('Do not know how to handle docblock type "%s"', get_class($docType)));
    }

    public static function range(Node $node, Element $element, int $fullStart = null): Range
    {
        return new Range(
            ByteOffset::fromInt($node->getFullStartPosition() + ($fullStart ?? $element->start())),
            ByteOffset::fromInt($node->getFullStartPosition() + $element->start()),
            ByteOffset::fromInt($node->getFullStartPosition() + $element->end())
        );
    }

    public static function element(Node $node, int $fullStart, Element $element): PhpactorElement
    {
        $range = DocblockBridge::range($node, $element, $fullStart);
        if ($element instanceof MethodTag) {
            return new MethodDeclarationElement(
                $range,
                $element->name->toString(),
                self::type($node, $element->type)
            );
        }

        return new UnmanagedElement(
            get_class($element),
            $range,
            []
        );
    }
}
