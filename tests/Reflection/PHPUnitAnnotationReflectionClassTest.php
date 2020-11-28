<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

use PHPUnit\Framework\TestCase;

class PHPUnitAnnotationReflectionClassTest extends TestCase
{
    /** @var PHPUnitAnnotationReflectionClass */
    protected $phpUnitAnnotationReflectionClass;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $reflectedClass = $this->prophesize(\ReflectionClass::class);

        $this->phpUnitAnnotationReflectionClass = new PHPUnitAnnotationReflectionClass($reflectedClass->reveal());
    }

    /**
     * @return array
     */
    public function parseFactoryAnnotationsDataProvider()
    {
        return [
            [
                '/**
                  * @var toto
                  */',
                [],
            ],
            [
                '/**
                  * @factory
                  */',
                [],
            ],
            [
                '/**
                  * @factory()
                  */',
                [],
            ],
            [
                '/**
                  * @factory("stdClass")
                  */',
                [
                    'className' => 'stdClass',
                    'params'    => [],
                ],
            ],
            [
                '/**
                  * @factory("/stdClass")
                  */',
                [
                    'className' => '/stdClass',
                    'params'    => [],
                ],
            ],
            [
                '/**
                  * @factory("\stdClass")
                  */',
                [
                    'className' => '\stdClass',
                    'params'    => [],
                ],
            ],
            [
                '/**
                  * @factory("\stdClass", params)
                  */',
                [],
            ],
            [
                '/**
                  * @factory("\stdClass", params={})
                  */',
                [
                    'className' => '\stdClass',
                    'params'    => [],
                ],
            ],
            [
                '/**
                  * @factory("\stdClass", params={toto})
                  */',
                [
                    'className' => '\stdClass',
                    'params'    => ['toto'],
                ],
            ],
            [
                '/**
                  * @factory("\stdClass", {"toto"})
                  */',
                [],
            ],
            [
                '/**
                  * @factory("\stdClass", params={toto})
                  */',
                [
                    'className' => '\stdClass',
                    'params'    => ['toto'],
                ],
            ],
            [
                '/**
                  * @factory("\stdClass", params={"toto"})
                  */',
                [
                    'className' => '\stdClass',
                    'params'    => ['toto'],
                ],
            ],
            [
                '/**
                  * @factory("\stdClass", params={"toto", "tata"})
                  */',
                [
                    'className' => '\stdClass',
                    'params'    => ['toto', 'tata'],
                ],
            ],
            [
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
            ],
            [
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
            ],
            [
                '/** @factory("\Namespace\stdClass", params={"toto0", "tata"}) */',
                [
                    'className' => '\Namespace\stdClass',
                    'params'    => ['toto0', 'tata'],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider parseFactoryAnnotationsDataProvider
     */
    public function itReturns($docblock, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->phpUnitAnnotationReflectionClass->parseFactoryAnnotations($docblock)
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsAnExceptionAsTheAnnotationIsSetTwice()
    {
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
