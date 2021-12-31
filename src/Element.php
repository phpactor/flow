<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Util\DebugHelper;
use RuntimeException;
use function mb_substr;

abstract class Element
{
    /**
     * @return Element[]
     */
    abstract public function children(): array;

    abstract public function range(): Range;

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

    /**
     * - Text until first child
     * - <child>
     * - Text after last child
     */
    public function toString(string $code)
    {
        $prefixStart = $this->range()->fullStart();
        $prefixEnd = $this->range()->end();
        $string = [];

        foreach ($this->children() as $child) {
            $prefixEnd = $child->range()->fullStart();
            break;
        }

        $string[] = mb_substr($code, $prefixStart->toInt(), $prefixEnd->toInt() - $prefixStart->toInt());

        foreach ($this->children() as $child) {
            $string[] = $child->toString($code);
            $prefixEnd = $child->range()->end();
        }

        $string[] = mb_substr(
            $code,
            $prefixEnd->toInt(),
            $this->range()->end()->toInt() - $prefixEnd->toInt()
        );

        return implode('', $string);
    }
}
