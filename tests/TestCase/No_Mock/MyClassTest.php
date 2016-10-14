<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\No_Mock;

use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

class MyClassTest extends PHPUnit_Annotation_TestCase
{
    /**
     * @var Bar
     *
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\No_Mock\Bar")
     */
    protected $bar;

    /**
     * @test
     */
    public function itReturnsAConcatenatedStringOfFoo()
    {
        $this->assertEquals('I am a Bar instance', $this->bar->dummy());
    }
}
