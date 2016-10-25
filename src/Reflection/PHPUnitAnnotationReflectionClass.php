<?php

namespace YoannRenard\PHPUnitAnnotation\Reflection;

class PHPUnitAnnotationReflectionClass
{
    /** @var \ReflectionClass */
    protected $reflectedClass;

    /**
     * @param \ReflectionClass $reflectedClass
     */
    public function __construct(\ReflectionClass $reflectedClass)
    {
        $this->reflectedClass = $reflectedClass;
    }

    /**
     * @return PHPUnitMockReflectionProperty[]
     */
    public function getMockProperties()
    {
        $annotation = [];
        foreach ($this->reflectedClass->getProperties() as $property) {
            $annotationList = $this->parseSimpleAnnotations($property->getDocComment());

            if (isset($annotationList['mock'][0])) {
                $annotation[] = new PHPUnitMockReflectionProperty($property->getName(), $annotationList['mock'][0]);
            }
        }

        return $annotation;
    }

    /**
     * @return PHPUnitFactoryReflectionProperty[]
     */
    public function getFactoryProperties()
    {
        $annotationList = [];
        foreach ($this->reflectedClass->getProperties() as $property) {
            $factoryAnnotation = $this->parseFactoryAnnotations($property->getDocComment());

            if (!empty($factoryAnnotation)) {
                $annotationList[] = new PHPUnitFactoryReflectionProperty(
                    $property->getName(),
                    $factoryAnnotation['className'],
                    $factoryAnnotation['params']
                );
            }
        }

        return $annotationList;
    }

    /**
     * @param string   $docBlock
     * @param string   $pattern
     * @param callable $callback
     *
     * @return array
     */
    private function parseAnnotations($docBlock, $pattern, callable $callback)
    {
        $annotations = [];
        // Strip away the docblock header and footer to ease parsing of one line annotations
        $docBlock = substr($docBlock, 3, -2);

        if (preg_match_all($pattern, $docBlock, $matches) && is_callable($callback)) {
            return call_user_func($callback, $matches);
        }

        return $annotations;
    }

    /**
     * @param string $docBlock
     *
     * @return array
     */
    public function parseSimpleAnnotations($docBlock)
    {
        return $this->parseAnnotations(
            $docBlock,
            '/@(?P<name>[A-Za-z_-]+)(?:[ \t]+(?P<value>.*?))?[ \t]*\r?$/m',
            function (array $matches) {
                $annotations = [];
                $numMatches = count($matches[0]);
                for ($i = 0; $i < $numMatches; ++$i) {
                    $annotations[$matches['name'][$i]][] = $matches['value'][$i];
                }

                return $annotations;
            }
        );
    }

    /**
     * @param string $docBlock
     *
     * @return array
     */
    public function parseFactoryAnnotations($docBlock)
    {
        return $this->parseAnnotations(
            $docBlock,
            '/@factory\("(?P<className>[\/\\\\A-Za-z0-9_-]+?)"(, params={(?P<params>[, \"\n\t*A-Za-z0-9_-]*)})?\)?[ \t]*\r?$/m',
            function (array $matches) {
                if (1 != count($matches[0])) {
                    throw new \InvalidArgumentException();
                }
                current($matches);

                // clean params
                $params = null;
                if (!empty($matches['params'][0])) {
                    $params = $matches['params'][0];
                    foreach (['*', ' ', "\n", "\t", "\r", '"'] as $char) {
                        $params = str_replace($char, '', $params);
                    }
                }

                return [
                    'className' => $matches['className'][0],
                    'params'    => !empty($params)? explode(',', $params):[],
                ];
            }
        );
    }
}
