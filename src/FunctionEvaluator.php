<?php

namespace Phpactor\Flow;

use MongoDB\BSON\Undefined;
use Phpactor\Flow\Type\MixedType;
use Phpactor\Name\FullyQualifiedName;

class FunctionEvaluator
{
    private array $functionEvaluators;

    public function __construct(array $functionEvaluators)
    {
        $this->functionEvaluators = $functionEvaluators;
    }

    /**
     * @return Type[]
     */
    public function evaluate(string $name, Types $arguments): Type
    {
        if (isset($this->functionEvaluators[$name])) {
            return $this->functionEvaluators[$name]->evaluate($arguments);
        }

        return new MixedType();
    }
}
