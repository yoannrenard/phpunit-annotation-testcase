<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted\Bar", params={"foo1", "foo2"})
     */
    protected Bar $sut;

    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted\Foo
     */
    protected $foo1;

    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted\Foo
     */
    protected $foo2;

    public function providesDummyData(): \Traversable
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
     * @dataProvider providesDummyData
     */
    public function itReturnsAConcatenatedStringOfFoo1AndFoo2(string $foo1, string $foo2, string $expectedDummy): void
    {
        $this->foo1->dummy()->willReturn($foo1);
        $this->foo2->dummy()->willReturn($foo2);

        $this->assertEquals($expectedDummy, $this->sut->dummy());
    }
}
