<?php

namespace Phpactor\Flow;

interface FunctionEvaluator
{
    public function evaluate(Types $arguments): Type;
}
