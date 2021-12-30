<?php

namespace Phpactor\Flow;

use Phpactor\TextDocument\ByteOffsetRange;

abstract class Element
{
    /**
     * @return Element[]
     */
    abstract public function children(): array;

    abstract public function range(): ByteOffsetRange;

    /**
     * @template T
     * @param class-string<T> $class
     * @return T
     */
    public function lastChildByClass(string $class): ?Element
    {
        $last = null;
        foreach ($this->children() as $child) {
            if ($child instanceof $class) {
                $last = $child;
            }
        }

        return $last;
    }

    public function type(): Type
    {
        return new InvalidType();
    }
}
