<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\TextDocument\ByteOffsetRange;

final class SourceCodeElement extends Element
{
    public function __construct(
        public ByteOffsetRange $range,
        public array $statements
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return $this->statements;
    }

    public function parent(): ?Element
    {
        return null;
    }

    public function range(): ByteOffsetRange
    {
    }
}
