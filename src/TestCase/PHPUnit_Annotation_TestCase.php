<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase;

use YoannRenard\PHPUnitAnnotation\Reflection\PHPUnitAnnotationReflectionClass;
use YoannRenard\PHPUnitAnnotation\Reflection\PHPUnitFactoryReflectionProperty;
use YoannRenard\PHPUnitAnnotation\Reflection\PHPUnitMockReflectionProperty;

class PHPUnit_Annotation_TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var PHPUnitAnnotationReflectionClass */
    protected $propertyAnnotation;

    /**
     * @inheritdoc
     */
    protected function setUp() {
        parent::setUp();

        // Init annotation
        // TODO Find out how to cache that
        $this->propertyAnnotation = new PHPUnitAnnotationReflectionClass(new \ReflectionClass($this));

        // Mocks
        /** @var PHPUnitMockReflectionProperty $mockReflectionProperty */
        foreach ($this->propertyAnnotation->getMockProperties() as $mockReflectionProperty) {
            $this->{$mockReflectionProperty->getName()} = $this->prophesize($mockReflectionProperty->getMockNamespace());
        }

        // Classes
        /** @var PHPUnitFactoryReflectionProperty $classReflectionProperty */
        foreach ($this->propertyAnnotation->getFactoryProperties() as $classReflectionProperty) {
            $classToTest = new \ReflectionClass($classReflectionProperty->getClassName());

            $this->{$classReflectionProperty->getName()} = $classToTest->newInstanceArgs(array_map(function($mockNamespace) {
                return $this->{$mockNamespace}->reveal();
            }, $classReflectionProperty->getParamList()));
        }
    }
}
