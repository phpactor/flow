<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;

interface ElementResolver
{
    public function resolve(Flow $interpreter, Frame $frame, Node $node): Element;
}
