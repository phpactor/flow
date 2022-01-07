<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Element\VariableElement;

final class Frame
{
    /**
     * @var array<string,NodeInfo>
     */
    private $vars = [];

    public static function new(): self
    {
        return new self();
    }

    public function setVariable(string $name, NodeInfo $info): void
    {
        $this->vars[$name] = $info;
    }

    public function getVariable(string $name): ?NodeInfo
    {
        if (!isset($this->vars[$name])) {
            return null;
        }

        return $this->vars[$name];
    }
}
