<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Mock;

use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

class MyClassTest extends PHPUnit_Annotation_TestCase
{
    /**
     * @mock \YoannRenard\PHPUnitAnnotation\TestCase\Mock\Foo
     * @var  Foo
     */
    protected $fooMock;

    /** @var Bar */
    protected $bar;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->bar = new Bar($this->fooMock->reveal());
    }

    /**
     * @test
     */
    public function itTest()
    {
        $this->fooMock->__toString()->willReturn('toto');

        $this->assertEquals('toto', $this->bar->getFoo()->__toString());
    }
}
