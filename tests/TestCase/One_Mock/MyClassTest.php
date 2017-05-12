<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
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
