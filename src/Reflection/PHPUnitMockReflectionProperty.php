<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

class PHPUnitMockReflectionProperty extends AbstractPHPUnitReflectionProperty
{
    protected string $mockNamespace;

    public function __construct(string $name, string $mockNamespace)
    {
        parent::__construct($name);

        $this->mockNamespace = $mockNamespace;
    }

    public function getMockNamespace(): string
    {
        return $this->mockNamespace;
    }
}
