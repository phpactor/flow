<?php

namespace Phpactor\Flow\Tests\Eval;

use Generator;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Microsoft\PhpParser\Parser;
use PHPUnit\Framework\TestCase;
use Phpactor\Flow\Element\ReturnStatementElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type\BooleanType;

class EvalauatorTest extends TestCase
{
    /**
     * @dataProvider provideEval
     */
    public function testEval(string $path): void
    {
        $code = file_get_contents($path);
        $interpreter = Interpreter::create();
        $parser = new Parser();
        $node = $parser->parseSourceFile($code);
        self::assertEquals(
            new BooleanType(true),
            $interpreter->interpret(
                Frame::new(),
                $node
            )->lastChildByClass(
                ReturnStatementElement::class
            )->expression()->type()
        );
        self::assertTrue(require($path));
    }

    public function provideEval(): Generator
    {
        foreach (glob(__DIR__ . '/*/*.phpt') as $path) {
            yield dirname($path) .'/'. basename($path) => [
                $path,
            ];
        }
    }

}
