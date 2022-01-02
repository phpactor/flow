<?php

namespace Phpactor\Flow;

use MongoDB\BSON\Undefined;
use Phpactor\Flow\Type\MixedType;
use Phpactor\Name\FullyQualifiedName;

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
