<?php

namespace Phpactor\Flow\Tests\Eval;

use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\Flow\Element\ReturnStatementElement;
use Phpactor\Flow\FlowBuilder;
use Phpactor\Flow\Type\BooleanType;
use Symfony\Component\Process\Process;

class EvalauatorTest extends TestCase
{
    /**
     * @dataProvider provideEval
     */
    public function testEval(string $path): void
    {
        $code = (string)file_get_contents($path);
        $flow = FlowBuilder::create()->withSource($code)->build();
        $interpreted = $flow->represent($code);

        self::assertEquals(
            new BooleanType(true),
            $interpreted->lastChildByClass(
                ReturnStatementElement::class
            )?->expression()->type(),
            'Analysed code returns true',
        );

        $process = new Process([
            PHP_BINARY,
        ], null, null, $code);
        $process->mustRun();

        dump($interpreted->toString($code));
        self::assertEquals(
            $code,
            $interpreted->toString($code),
            'Converts back to original source'
        );
    }

    /**
     * @return Generator<mixed>
     */
    public function provideEval(): Generator
    {
        foreach ((array)glob(__DIR__ . '/*/*.phpt') as $path) {
            yield dirname((string)$path) .'/'. basename((string)$path) => [
                $path,
            ];
        }
    }
}
