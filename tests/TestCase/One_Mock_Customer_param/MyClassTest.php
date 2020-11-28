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
    protected $foo;

    protected Bar $sut;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new Bar($this->foo->reveal(), 'my suffix');
    }

    /** @test */
    public function itReturnsASpecificString(): void
    {
        $this->foo->dummy()->willReturn('Foo');

        $this->assertEquals('Foo my suffix', $this->sut->dummy());
    }
}
