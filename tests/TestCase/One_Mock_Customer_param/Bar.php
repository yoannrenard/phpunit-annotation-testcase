<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock_Customer_param;

class Bar
{
    protected Foo $foo;
    protected string $suffix;

    public function __construct(Foo $foo, string $suffix)
    {
        $this->foo    = $foo;
        $this->suffix = $suffix;
    }

    public function dummy(): string
    {
        return sprintf('%s %s', $this->foo->dummy(), $this->suffix);
    }
}
