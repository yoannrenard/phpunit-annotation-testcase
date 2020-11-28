<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock_Customer_param;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @var Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\One_Mock_Customer_param\Foo
     */
    protected $fooMock;

    protected Bar $bar;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bar = new Bar($this->fooMock->reveal(), 'my suffix');
    }

    /** @test */
    public function itReturnsASpecificString()
    {
        $this->fooMock->dummy()->willReturn('Foo');

        $this->assertEquals('Foo my suffix', $this->bar->dummy());
    }
}
