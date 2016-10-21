<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

class MyClassTest extends PHPUnit_Annotation_TestCase
{
    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\One_Mock\Foo
     */
    protected $fooMock;

    /**
     * @var Bar
     *
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\One_Mock\Bar", params={"fooMock"})
     */
    protected $bar;

    /**
     * @test
     */
    public function itReturnsASpecificString()
    {
        $this->fooMock->dummy()->willReturn('Foo');

        $this->assertEquals('Foo', $this->bar->dummy());
    }
}
