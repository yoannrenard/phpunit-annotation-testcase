<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use YoannRenard\PHPUnitAnnotation\Reflection\PHPUnitAnnotationReflectionClass;

class AnnotationTestCase extends TestCase
{
    use ProphecyTrait;

    /** @var PHPUnitAnnotationReflectionClass[] */
    protected static array $propertyAnnotationList;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Init annotation
        $className = get_class($this);
        if (!isset(self::$propertyAnnotationList[$className])) {
            self::$propertyAnnotationList[$className] = new PHPUnitAnnotationReflectionClass(new \ReflectionClass($this));
        }

        // Mocks
        foreach (self::$propertyAnnotationList[$className]->getMockProperties() as $mockReflectionProperty) {
            $this->{$mockReflectionProperty->name()} = $this->prophesize($mockReflectionProperty->mockNamespace());
        }

        // Classes
        foreach (self::$propertyAnnotationList[$className]->getFactoryProperties() as $classReflectionProperty) {
            $classToTest = new \ReflectionClass($classReflectionProperty->className());

            $this->{$classReflectionProperty->name()} = $classToTest->newInstanceArgs(array_map(function($mockNamespace) {
                return $this->{$mockNamespace}->reveal();
            }, $classReflectionProperty->paramList()));
        }
    }
}
