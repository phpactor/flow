<?php

namespace Phpactor\Flow\Evaluator;

use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\StringType;
use Phpactor\Flow\Types;

class GetClassEvaluator
{
    public function evaluate(Types $arguments): Type
    {
        $first = $arguments->firstOrNull();
        if ($first instanceof ClassType) {
            return new StringType((string)$first->fqn());
        }

        return new InvalidType('Argument passed to get_class was not a class type');
    }
}

