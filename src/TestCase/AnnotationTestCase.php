<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase;

use PHPUnit\Framework\TestCase;
use YoannRenard\PHPUnitAnnotation\Reflection\PHPUnitAnnotationReflectionClass;
use YoannRenard\PHPUnitAnnotation\Reflection\PHPUnitFactoryReflectionProperty;
use YoannRenard\PHPUnitAnnotation\Reflection\PHPUnitMockReflectionProperty;

class AnnotationTestCase extends TestCase
{
    /** @var PHPUnitAnnotationReflectionClass[] */
    protected static $propertyAnnotationList;

    /**
     * @inheritdoc
     */
    protected function setUp() {
        parent::setUp();

        // Init annotation
        $className = get_class($this);
        if (!isset(self::$propertyAnnotationList[$className])) {
            self::$propertyAnnotationList[$className] = new PHPUnitAnnotationReflectionClass(new \ReflectionClass($this));
        }

        // Mocks
        /** @var PHPUnitMockReflectionProperty $mockReflectionProperty */
        foreach (self::$propertyAnnotationList[$className]->getMockProperties() as $mockReflectionProperty) {
            $this->{$mockReflectionProperty->getName()} = $this->prophesize($mockReflectionProperty->getMockNamespace());
        }

        // Classes
        /** @var PHPUnitFactoryReflectionProperty $classReflectionProperty */
        foreach (self::$propertyAnnotationList[$className]->getFactoryProperties() as $classReflectionProperty) {
            $classToTest = new \ReflectionClass($classReflectionProperty->getClassName());

            $this->{$classReflectionProperty->getName()} = $classToTest->newInstanceArgs(array_map(function($mockNamespace) {
                return $this->{$mockNamespace}->reveal();
            }, $classReflectionProperty->getParamList()));
        }
    }
}
