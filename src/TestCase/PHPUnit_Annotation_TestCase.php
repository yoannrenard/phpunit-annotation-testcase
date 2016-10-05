<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase;

abstract class PHPUnit_Annotation_TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp() {
        parent::setUp();
        
        die('ok');
    }
}
