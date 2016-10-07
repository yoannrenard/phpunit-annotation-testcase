<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Mock;

class Foo
{
    /**
     * @return string
     */
    public function __toString()
    {
        return 'I am a Foo instance';
    }
}
