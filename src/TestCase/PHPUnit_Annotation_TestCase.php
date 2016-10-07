<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase;

abstract class PHPUnit_Annotation_TestCase extends \PHPUnit_Framework_TestCase
{
    const REGEX_MOCK = '/@mock\s+([a-zA-Z0-9._:-\\\\x7f-\xff]+)/';

    /**
     * @inheritdoc
     */
    protected function setUp() {
        parent::setUp();

        $class = new \ReflectionClass($this);
        $propertyList = $class->getProperties();
        foreach ($propertyList as $property) {
            $docComment = $property->getDocComment();
            if (preg_match(self::REGEX_MOCK, $docComment, $matches)) {
                $annotationList = $this->parseAnnotations($docComment);

                if (isset($annotationList['mock'][0])) {
                    $this->{$property->getName()} = $this->prophesize($annotationList['mock'][0]);
                }
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
}
