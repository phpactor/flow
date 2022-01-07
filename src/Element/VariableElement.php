<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

final class VariableElement extends Element
{
    public function __construct(
        private Range $range,
        private string $name,
        private Type $type
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [];
    }

    public function range(): Range
    {
        return $this->range;
    }

    public function withType(Type $type): self
    {
        return new self($this->range, $this->name, $type);
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }
}
