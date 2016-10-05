<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Mock;

class Bar
{
    /** @var Foo */
    protected $foo;

    /**
     * @param Foo $foo
     */
    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }
}
