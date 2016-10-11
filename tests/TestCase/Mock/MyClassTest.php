<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Mock;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

class MyClassTest extends PHPUnit_Annotation_TestCase
{
    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Mock\Foo
     */
    protected $foo1Mock;

    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Mock\Foo
     */
    protected $foo2Mock;

    /**
     * @var Bar
     *
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\Mock\Bar", params={"foo1Mock", "foo2Mock"})
     */
    protected $bar;

    /**
     * @test
     */
    public function itTest()
    {
        $this->foo1Mock->__toString()->willReturn('toto');
        $this->foo2Mock->__toString()->willReturn('tata');

        $this->assertEquals('dummy', $this->bar->returnDummy());
        $this->assertEquals('toto', $this->bar->getFoo()->__toString());
    }
}
