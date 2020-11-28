<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @var Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\One_Mock\Foo
     */
    protected $fooMock;

    /**
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\One_Mock\Bar", params={"fooMock"})
     */
    protected Bar $bar;

    /** @test */
    public function itReturnsASpecificString(): void
    {
        $this->fooMock->dummy()->willReturn('Foo');

        $this->assertEquals('Foo', $this->bar->dummy());
    }
}
