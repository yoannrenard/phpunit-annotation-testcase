<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

class PHPUnitMockReflectionProperty extends AbstractPHPUnitReflectionProperty
{
    /** @var string */
    protected $mockNamespace;

    /**
     * @param string $name
     * @param string $mockNamespace
     */
    public function __construct($name, $mockNamespace)
    {
        parent::__construct($name);

        $this->mockNamespace = $mockNamespace;
    }

    /**
     * @return string
     */
    public function getMockNamespace()
    {
        return $this->mockNamespace;
    }
}
