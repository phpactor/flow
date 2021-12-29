<?php

namespace Phpactor\Flow\Tests\Eval;

use Generator;
use Microsoft\PhpParser\Parser;
use PHPUnit\Framework\TestCase;
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
        $interpreter = new Interpreter();
        $parser = new Parser();
        $node = $parser->parseSourceFile($code);
        self::assertEquals(new BooleanType(true), $interpreter->interpret($node));
    }

    public function provideEval(): Generator
    {
        foreach (glob(__DIR__ . '/*/*.phpt') as $path) {
            yield basename($path) => [
                $path,
            ];
        }
    }

}
