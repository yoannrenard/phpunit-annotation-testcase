<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

abstract class AbstractPHPUnitReflectionProperty
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
