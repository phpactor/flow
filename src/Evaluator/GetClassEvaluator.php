<?php

namespace Phpactor\Flow\Evaluator;

use Phpactor\Flow\FunctionEvaluator;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\StringType;
use Phpactor\Flow\Types;
use Phpactor\Flow\Type\UnionType;

class GetClassEvaluator implements FunctionEvaluator
{
    public function evaluate(Types $arguments): Type
    {
        $first = $arguments->firstOrNull();

        if ($first instanceof UnionType) {
            $types = [];
            foreach ($first->types() as $type) {
                if (!$type instanceof ClassType) {
                    continue;
                }
                $types[] = (string)$type->fqn();
            }
            return new UnionType(new Types(array_map(
                fn(string $fqn) => new StringType($fqn),
                $types
            )));
        }

        if ($first instanceof ClassType) {
            return new StringType((string)$first->fqn());
        }

        return new InvalidType('Argument passed to get_class was not a class type');
    }
}

