<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;

interface ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element;
}
