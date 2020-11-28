<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock;

class Bar
{
    protected Foo $foo;

    /**
     * @param Foo $foo
     */
    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }

    public function dummy(): string
    {
        return $this->foo->dummy();
    }
}
