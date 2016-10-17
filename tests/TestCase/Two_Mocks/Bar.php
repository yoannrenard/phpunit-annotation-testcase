<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks;

class Bar
{
    /** @var Foo */
    protected $foo1;

    /** @var Foo */
    protected $foo2;

    /**
     * @param Foo $foo1
     * @param Foo $foo2
     */
    public function __construct(Foo $foo1, Foo $foo2)
    {
        $this->foo1 = $foo1;
        $this->foo2 = $foo2;
    }

    public function dummy()
    {
        return $this->foo1->dummy().' '.$this->foo2->dummy();
    }
}
