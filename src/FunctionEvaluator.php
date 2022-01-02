<?php

namespace Phpactor\Flow;

use MongoDB\BSON\Undefined;
use Phpactor\Flow\Type\MixedType;
use Phpactor\Name\FullyQualifiedName;

interface FunctionEvaluator
{
    public function evaluate(Types $arguments): Type;
}
