<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Parser;

final class Flow
{
    public function __construct(private Parser $parser, private Interpreter $interpreter)
    {
    }

    public function represent(string $sourceCode): Element
    {
        $node = $this->parser->parseSourceFile($sourceCode);
        return $this->interpreter->interpret(new Frame(), $node);
    }
}
