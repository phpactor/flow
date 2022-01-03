<?php

namespace Phpactor\Flow\Util;

use Microsoft\PhpParser\Node;
use Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor\DocblockParser\Ast\Type\ClassNode;
use Phpactor\DocblockParser\Ast\Type\UnionNode;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\UnionType;
use Phpactor\Flow\Types;
use Phpactor\Name\FullyQualifiedName;

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
}
