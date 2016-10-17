<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

class MyClassTest extends PHPUnit_Annotation_TestCase
{
    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Foo
     */
    protected $foo1Mock;

    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Foo
     */
    protected $foo2Mock;

    /**
     * @var Bar
     *
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks\Bar", params={"foo1Mock", "foo2Mock"})
     */
    protected $bar;

    /**
     * @return array
     */
    public function dummyDataProvider()
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
    public function itReturnsAConcatenatedStringOfFoo1AndFoo2($foo1, $foo2, $expectedDummy)
    {
        $this->foo1Mock->dummy()->willReturn($foo1);
        $this->foo2Mock->dummy()->willReturn($foo2);

        $this->assertEquals($expectedDummy, $this->bar->dummy());
    }
}
