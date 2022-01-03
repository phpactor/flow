<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Type\MixedType;

final class FunctionExecutor
{
    /**
     * @param FunctionEvaluator[] $functionEvaluators
     */
    public function __construct(private array $functionEvaluators)
    {
    }

    public function evaluate(string $name, Types $arguments): Type
    {
        if (isset($this->functionEvaluators[$name])) {
            return $this->functionEvaluators[$name]->evaluate($arguments);
        }

        return new MixedType();
    }
}
