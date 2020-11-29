<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

class PHPUnitFactoryReflectionProperty
{
    protected string $name;
    protected string $className;

    /** @var string[] */
    protected array $paramList;

    /**
     * @param string[] $paramList
     */
    public function __construct(string $name, string $className, array $paramList = [])
    {
        $this->name = $name;
        $this->className = $className;
        $this->paramList = $paramList;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function className(): string
    {
        return $this->className;
    }

    /**
     * @return string[]
     */
    public function paramList(): array
    {
        return $this->paramList;
    }
}
