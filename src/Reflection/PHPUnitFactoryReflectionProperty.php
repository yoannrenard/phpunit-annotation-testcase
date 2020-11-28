<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

class PHPUnitFactoryReflectionProperty extends AbstractPHPUnitReflectionProperty
{
    protected string $className;

    /** @var string[] */
    protected array $paramList;

    /**
     * @param string[] $paramList
     */
    public function __construct(string $name, string $className, array $paramList = [])
    {
        parent::__construct($name);

        $this->className = $className;
        $this->paramList = $paramList;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string[]
     */
    public function getParamList(): array
    {
        return $this->paramList;
    }
}
