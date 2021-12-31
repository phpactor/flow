<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Util\DebugHelper;
use Phpactor\TextDocument\ByteOffsetRange;
use RuntimeException;

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
        if (DebugHelper::isDebug()) {
            throw new RuntimeException(sprintf(
                'Type not implemented: "%s"', get_class($this)
            ));
        }

        return new InvalidType();
    }
}
