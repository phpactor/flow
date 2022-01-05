<?php

namespace Phpactor\Flow\Reflection\Collection;

use Generator;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\MethodDeclarationElement;
use Phpactor\Flow\Reflection\ReflectionMethod;
use Phpactor\Flow\Types;
use function iterator_to_array;

/**
 * @extends MemberCollection<ReflectionMethod>
 */
final class MethodCollection extends MemberCollection
{
    public static function fromElement(ClassDeclarationElement $element, Types $arguments): MethodCollection
    {
        return new MethodCollection(array_map(
            function (MethodDeclarationElement $e) {
                return new ReflectionMethod($e->name(), $e->type());
            },
            iterator_to_array(
                (function ()use ($element): Generator {
                    foreach ($element->docblock()->childrenByClass(MethodDeclarationElement::class) as $m) {
                        yield $m;
                    }
                    foreach ($element->members()->childrenByClass(MethodDeclarationElement::class) as $m) {
                        yield $m;
                    }
                })()
            )
        ));
    }
}
