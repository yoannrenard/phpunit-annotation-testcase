<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

class PHPUnitFactoryReflectionProperty extends AbstractPHPUnitReflectionProperty
{
    /** @var string */
    protected $className;

    /** @var string[] */
    protected $paramList;

    /**
     * @param string   $name
     * @param string   $className
     * @param string[] $paramList
     */
    public function __construct($name, $className, array $paramList = [])
    {
        parent::__construct($name);

        $this->className = $className;
        $this->paramList = $paramList;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string[]
     */
    public function getParamList()
    {
        return $this->paramList;
    }
}
