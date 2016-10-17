<?php

namespace YoannRenard\PHPUnitAnnotation\TestCase\One_Mock_Customer_param;

class Bar
{
    /** @var Foo */
    protected $foo;

    /** @var string */
    protected $suffix;

    /**
     * @param Foo    $foo
     * @param string $suffix
     */
    public function __construct(Foo $foo, $suffix)
    {
        $this->foo    = $foo;
        $this->suffix = $suffix;
    }

    /**
     * @return string
     */
    public function dummy()
    {
        return sprintf('%s %s', $this->foo->dummy(), $this->suffix);
    }
}
