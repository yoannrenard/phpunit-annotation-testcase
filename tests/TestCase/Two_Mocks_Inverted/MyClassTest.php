<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted\Bar", params={"foo1Mock", "foo2Mock"})
     */
    protected Bar $bar;

    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted\Foo
     */
    protected $foo1Mock;

    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted\Foo
     */
    protected $foo2Mock;

    public function dummyDataProvider(): array
    {
        return [
            [
                '',
                '',
                ' ',
            ],
            [
                'a',
                '',
                'a ',
            ],
            [
                '',
                'b',
                ' b',
            ],
            [
                'a',
                'b',
                'a b',
            ],
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
