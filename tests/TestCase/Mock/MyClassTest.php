<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Mock;

use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

class MyClassTest extends PHPUnit_Annotation_TestCase
{
    /**
     * @mock Foo
     * @var  Foo
     */
    protected $foo;

    /** @var Bar */
    protected $bar;

    /**
     * @inheritdoc
     */
    protected function setUp() {
        parent::setUp();

        $this->bar = new Bar($this->foo);
    }
}
