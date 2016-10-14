<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock;

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

    /**
     * @return string
     */
    public function dummy()
    {
        return $this->foo->dummy();
    }
}
