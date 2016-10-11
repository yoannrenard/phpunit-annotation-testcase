<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase;

class PHPUnit_Annotation_TestCaseTest extends \PHPUnit_Framework_TestCase
{
    /** @var PHPUnit_Annotation_TestCase */
    protected $phpUnitAnnotationTestCase;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->phpUnitAnnotationTestCase = new PHPUnit_Annotation_TestCase();
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
            $this->phpUnitAnnotationTestCase->parseFactoryAnnotations($docblock)
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsAnExceptionAsTheAnnotationIsSetTwice()
    {
        $this->phpUnitAnnotationTestCase->parseFactoryAnnotations(<<<EOF
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
