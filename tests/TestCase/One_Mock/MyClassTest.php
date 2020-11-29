<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\One_Mock\Foo
     */
    protected Foo|ObjectProphecy $foo;

    /**
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\One_Mock\Bar", params={"foo"})
     */
    protected Bar $sut;

    /** @test */
    public function itReturnsASpecificString(): void
    {
        $this->foo->dummy()->willReturn('Foo');

        $this->assertEquals('Foo', $this->sut->dummy());
    }
}
