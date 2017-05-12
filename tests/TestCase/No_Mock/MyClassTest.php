<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\No_Mock;

use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
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
    public function itReturnsASpecificString()
    {
        $this->assertEquals('I am a Bar instance', $this->bar->dummy());
    }
}
