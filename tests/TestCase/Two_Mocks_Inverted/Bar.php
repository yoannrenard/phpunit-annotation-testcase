<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\Two_Mocks_Inverted;

class Bar
{
    protected Foo $foo1;
    protected Foo $foo2;

    public function __construct(Foo $foo1, Foo $foo2)
    {
        $this->foo1 = $foo1;
        $this->foo2 = $foo2;
    }

    public function dummy(): string
    {
        return $this->foo1->dummy().' '.$this->foo2->dummy();
    }
}
