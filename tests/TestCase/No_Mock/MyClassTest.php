<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\No_Mock;

use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class MyClassTest extends AnnotationTestCase
{
    /**
     * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\No_Mock\Bar")
     */
    protected Bar $bar;

    /** @test */
    public function itReturnsASpecificString(): void
    {
        $this->assertEquals('I am a Bar instance', $this->bar->dummy());
    }
}
