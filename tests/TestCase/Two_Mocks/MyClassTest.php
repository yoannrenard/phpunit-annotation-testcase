<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @var Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Foo
     */
    protected $foo1Mock;

    /**
     * @var Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Foo
     */
    protected $foo2Mock;

    /**
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Bar", params={"foo1Mock", "foo2Mock"})
     */
    protected Bar $bar;

    public function dummyDataProvider(): \Traversable
    {
        yield 'Empty strings' => [
            '',
            '',
            ' ',
        ];

        yield '"a" + "" = "a "' => [
            'a',
            '',
            'a ',
        ];

        yield '"" + "b" = " b"' => [
            '',
            'b',
            ' b',
        ];

        yield '"a" + "b" = "a b"' => [
            'a',
            'b',
            'a b',
        ];
    }

    /**
     * @test
     * @dataProvider dummyDataProvider
     */
    public function itReturnsAConcatenatedStringOfFoo1AndFoo2(string $foo1, string $foo2, string $expectedDummy)
    {
        $this->foo1Mock->dummy()->willReturn($foo1);
        $this->foo2Mock->dummy()->willReturn($foo2);

        $this->assertEquals($expectedDummy, $this->bar->dummy());
    }
}
