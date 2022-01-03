<?php

namespace Phpactor\Flow;

use Phpactor\DocblockParser\Ast\Docblock;
use Phpactor\DocblockParser\Lexer;
use Phpactor\DocblockParser\Parser;
use RuntimeException;

class DocblockFactory
{
    public function __construct(private Lexer $lexer, private Parser $parser)
    {
    }

    public function create(string $docblock): Docblock
    {
        $block = $this->parser->parse($this->lexer->lex($docblock));
        if (!$block instanceof Docblock) {
            throw new RuntimeException(sprintf(
                'Expected a Docblock got a "%s"',
                get_class($block)
            ));
        }
        return $block;
    }
}
