<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Foo
     */
    protected Foo|ObjectProphecy $foo1;

    /**
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Foo
     */
    protected Foo|ObjectProphecy $foo2;

    /**
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Bar", params={"foo1", "foo2"})
     */
    protected Bar $sut;

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
    public function itReturnsAConcatenatedStringOfFoo1AndFoo2(string $foo1, string $foo2, string $expectedDummy): void
    {
        $this->foo1->dummy()->willReturn($foo1);
        $this->foo2->dummy()->willReturn($foo2);

        $this->assertEquals($expectedDummy, $this->sut->dummy());
    }
}
