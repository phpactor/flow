<?php

namespace Phpactor\Flow\Reflection\Collection;

use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\MethodDeclarationElement;
use Phpactor\Flow\Reflection\ReflectionMember;
use Phpactor\Flow\Reflection\ReflectionMethod;
use Phpactor\Flow\Types;

/**
 * @extends MemberCollection<ReflectionMethod>
 */
final class MethodCollection extends MemberCollection
{
    public static function fromElement(ClassDeclarationElement $element, Types $arguments): MethodCollection
    {
        return new MethodCollection(array_map(
            fn(MethodDeclarationElement $e) => new ReflectionMethod($e->name(), $e->type()),
            iterator_to_array($element->childrenByClass(MethodDeclarationElement::class))
        ));
    }
}
