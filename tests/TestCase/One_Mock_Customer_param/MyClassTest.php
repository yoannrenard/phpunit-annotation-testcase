<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock_Customer_param;

use Prophecy\Prophecy\ObjectProphecy;
use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

class MyClassTest extends PHPUnit_Annotation_TestCase
{
    /**
     * @var  Foo|ObjectProphecy
     *
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\One_Mock_Customer_param\Foo
     */
    protected $fooMock;

    /**
     * @var Bar
     */
    protected $bar;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->bar = new Bar($this->fooMock->reveal(), 'my suffix');
    }

    /**
     * @test
     */
    public function itReturnsAConcatenatedStringOfFoo()
    {
        $this->fooMock->dummy()->willReturn('Foo');

        $this->assertEquals('Foo my suffix', $this->bar->dummy());
    }
}
