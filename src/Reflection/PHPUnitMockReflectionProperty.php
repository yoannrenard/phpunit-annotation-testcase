<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

class PHPUnitMockReflectionProperty
{
    protected string $name;
    protected string $mockNamespace;

    public function __construct(string $name, string $mockNamespace)
    {
        $this->name = $name;
        $this->mockNamespace = $mockNamespace;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function mockNamespace(): string
    {
        return $this->mockNamespace;
    }
}
