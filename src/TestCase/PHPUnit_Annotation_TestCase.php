<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase;

class PHPUnit_Annotation_TestCase extends \PHPUnit_Framework_TestCase
{
    const REGEX_MOCK = '/@mock\s+([a-zA-Z0-9._:-\\\\x7f-\xff]+)/';

    /**
     * @inheritdoc
     */
    protected function setUp() {
        parent::setUp();

        $class = new \ReflectionClass($this);
        $propertyList = $class->getProperties();

        // Mocks
        foreach ($propertyList as $property) {
            $docComment = $property->getDocComment();

            if (preg_match(self::REGEX_MOCK, $docComment, $matches)) {
                $annotationList = $this->parseAnnotations($docComment);

                if (isset($annotationList['mock'][0])) {
                    $this->{$property->getName()} = $this->prophesize($annotationList['mock'][0]);
                }
            }
        }

        // Class to test
        foreach ($propertyList as $property) {
            $docComment = $property->getDocComment();

            $factoryAnnotation = $this->parseFactoryAnnotations($docComment);
            if (!empty($factoryAnnotation)) {
                $paramList = [];
                foreach ($factoryAnnotation['params'] as $paramName) {
                    $paramList[] = $this->{$paramName}->reveal();
                }

                $classToTest = new \ReflectionClass($factoryAnnotation['className']);
                $this->{$property->getName()} = $classToTest->newInstanceArgs($paramList);
            }
        }
    }

    /**
     * @param string $docblock
     *
     * @return array
     *
     * TODO: use a proper method from PHPUnit_Util_Test because this one is copied/pasted from PHPUnit_Util_Test::parseAnnotations() which is private
     */
    private function parseAnnotations($docblock)
    {
        $annotations = [];
        // Strip away the docblock header and footer to ease parsing of one line annotations
        $docblock = substr($docblock, 3, -2);

        if (preg_match_all('/@(?P<name>[A-Za-z_-]+)(?:[ \t]+(?P<value>.*?))?[ \t]*\r?$/m', $docblock, $matches)) {
            $numMatches = count($matches[0]);

            for ($i = 0; $i < $numMatches; ++$i) {
                $annotations[$matches['name'][$i]][] = $matches['value'][$i];
            }
        }

        return $annotations;
    }

    /**
     * @param string $docblock
     *
     * @return array
     */
    public function parseFactoryAnnotations($docblock)
    {
        $annotations = [];
        // Strip away the docblock header and footer to ease parsing of one line annotations
        $docblock = substr($docblock, 3, -2);

        if (preg_match_all('/@factory\("(?P<className>[\/\\\\A-Za-z_-]+?)"(, params=(?P<params>[{}, \"\n\t*A-Za-z0-9_-]*))?\)?[ \t]*\r?$/m', $docblock, $matches)) {
            if (1 < count($matches[0])) {
                throw new \InvalidArgumentException();
            }
            current($matches);

            $params = null;

            // clean params
            if (!empty($matches['params'][0])) {
                $params = $matches['params'][0];
                $params = str_replace('*', '', $params);
                $params = str_replace(' ', '', $params);
                $params = str_replace("\n", '', $params);
                $params = str_replace("\t", '', $params);
                $params = str_replace("\r", '', $params);
                $params = str_replace(',', ', ', $params);

                $params = str_replace('{', '', $params);
                $params = str_replace('}', '', $params);
                $params = str_replace('"', '', $params);
            }

            // format params
            $paramList = [];
            if (!empty($params)) {
                $paramList = explode(', ', $params);
            }

            $annotations = [
                'className' => $matches['className'][0],
                'params'    => $paramList,
            ];
        }

        return $annotations;
    }
}
