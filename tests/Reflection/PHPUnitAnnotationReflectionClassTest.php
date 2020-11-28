<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

use PHPUnit\Framework\TestCase;

class PHPUnitAnnotationReflectionClassTest extends TestCase
{
    protected PHPUnitAnnotationReflectionClass $phpUnitAnnotationReflectionClass;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $reflectedClass = $this->prophesize(\ReflectionClass::class);

        $this->phpUnitAnnotationReflectionClass = new PHPUnitAnnotationReflectionClass($reflectedClass->reveal());
    }

    public function parseFactoryAnnotationsDataProvider(): \Traversable
    {
        yield '@var toto' => [
            '/**
              * @var toto
              */',
            [],
        ];

        yield '@factory' => [
            '/**
              * @factory
              */',
            [],
        ];

        yield '@factory()' => [
            '/**
              * @factory()
              */',
            [],
        ];

        yield '@factory("stdClass")' => [
            '/**
              * @factory("stdClass")
              */',
            [
                'className' => 'stdClass',
                'params'    => [],
            ],
        ];

        yield '@factory("/stdClass")' => [
            '/**
              * @factory("/stdClass")
              */',
            [
                'className' => '/stdClass',
                'params'    => [],
            ],
        ];

        yield '@factory("\stdClass")' => [
            '/**
              * @factory("\stdClass")
              */',
            [
                'className' => '\stdClass',
                'params'    => [],
            ],
        ];

        yield '@factory("\stdClass", params)' => [
            '/**
              * @factory("\stdClass", params)
              */',
            [],
        ];

        yield '@factory("\stdClass", params={})' => [
            '/**
              * @factory("\stdClass", params={})
              */',
            [
                'className' => '\stdClass',
                'params'    => [],
            ],
        ];

        yield '@factory("\stdClass", params={toto})' => [
            '/**
              * @factory("\stdClass", params={toto})
              */',
            [
                'className' => '\stdClass',
                'params'    => ['toto'],
            ],
        ];

        yield '@factory("\stdClass", {"toto"})' => [
            '/**
              * @factory("\stdClass", {"toto"})
              */',
            [],
        ];

        yield '@factory("\stdClass", params={toto})' =>    [
            '/**
              * @factory("\stdClass", params={toto})
              */',
            [
                'className' => '\stdClass',
                'params'    => ['toto'],
            ],
        ];

        yield '@factory("\stdClass", params={"toto"})' => [
            '/**
              * @factory("\stdClass", params={"toto"})
              */',
            [
                'className' => '\stdClass',
                'params'    => ['toto'],
            ],
        ];

        yield '@factory("\stdClass", params={"toto", "tata"})' => [
            '/**
              * @factory("\stdClass", params={"toto", "tata"})
              */',
            [
                'className' => '\stdClass',
                'params'    => ['toto', 'tata'],
            ],
        ];

        yield '@factory("\Namespace\stdClass", params={
                 "toto",
                 "tata"
               })' => [
            '/**
              * @factory("\Namespace\stdClass", params={
              *   "toto",
              *   "tata"
              * })
              */',
            [
                'className' => '\Namespace\stdClass',
                'params'    => ['toto', 'tata'],
            ],
        ];
        yield '@factory("\Namespace\stdClass", params={
                 "toto",
                 "tata"
               })' => [
            '/**
              * @var toto
              *
              * @factory("\Namespace\stdClass", params={
              *   "toto",
              *   "tata"
              * })
              */',
            [
                'className' => '\Namespace\stdClass',
                'params'    => ['toto', 'tata'],
            ],
        ];

        yield '@factory("\Namespace\stdClass", params={"toto0", "tata"})' => [
            '/** @factory("\Namespace\stdClass", params={"toto0", "tata"}) */',
            [
                'className' => '\Namespace\stdClass',
                'params'    => ['toto0', 'tata'],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider parseFactoryAnnotationsDataProvider
     */
    public function itReturns(string $docblock, array $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->phpUnitAnnotationReflectionClass->parseFactoryAnnotations($docblock)
        );
    }

    /** @test */
    public function itThrowsAnExceptionAsTheAnnotationIsSetTwice()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->phpUnitAnnotationReflectionClass->parseFactoryAnnotations(<<<EOF
/**
 * @var toto
 *
 * @factory("\Namespace\stdClass", params={
 *   "toto",
 *   "tata"
 * })
 *
 * @factory("\Namespace\stdClass", params={
 *   "toto",
 *   "tata"
 * })
 */
EOF
        );
    }
}
