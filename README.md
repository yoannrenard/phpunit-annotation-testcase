# phpunit-annotation-testcase

Use simple annotations to mock the world!

## Installing Dependencies

Use [Composer][composer] and run :

```bash
$> composer require --dev yoannrenard/phpunit-annotation-testcase
```

## Requirements

* [Composer][composer]
* PHP >=5.6

## Run tests

```bash
$> bin/phpunit
```

## Usage

    <?php
    use Prophecy\Prophecy\ObjectProphecy;
    use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

    class MyClassTest extends PHPUnit_Annotation_TestCase
    {
        /**
         * @var  Foo|ObjectProphecy
         *
         * @mock <namespace>\Foo
         */
        protected $fooMock;

        /** @var Bar */
        protected $bar;

        /**
         * @inheritdoc
         */
        protected function setUp()
        {
            parent::setUp();

            $this->bar = new Bar($this->fooMock->reveal());
        }
    }

will replace

    <?php
    use Prophecy\Prophecy\ObjectProphecy;
    use YoannRenard\PHPUnitAnnotation\TestCase\PHPUnit_Annotation_TestCase;

    class MyClassTest extends PHPUnit_Annotation_TestCase
    {
        /**
         * @var Foo|ObjectProphecy
         */
        protected $fooMock;

        /** @var Bar */
        protected $bar;

        /**
         * @inheritdoc
         */
        protected function setUp()
        {
            parent::setUp();

            $this->fooMock = $this->prophesize(Foo::class);

            $this->bar = new Bar($this->fooMock->reveal());
        }
    }

[composer]: https://getcomposer.org
