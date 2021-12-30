<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Element\VariableElement;

final class Frame
{
    /**
     * @var array<string,VariableElement>
     */
    private $vars = [];

    public static function new(): self
    {
        return new self();
    }

    public function setVariable(VariableElement $variable)
    {
        $this->vars[$variable->name()] = $variable;
    }

    public function getVariable(string $name): ?VariableElement
    {
        if (!isset($this->vars[$name])) {
            return null;
        }

        return $this->vars[$name];
    }
}
