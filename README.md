# phpunit-annotation-testcase

[![Build Status](https://travis-ci.org/yoannrenard/phpunit-annotation-testcase.svg?branch=master)](https://travis-ci.org/yoannrenard/phpunit-annotation-testcase)

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
    use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

    class MyClassTest extends AnnotationTestCase
    {
        /**
         * @var  Foo|ObjectProphecy
         *
         * @mock <namespace>\Foo
         */
        protected $fooMock;

        /**
         * @var Bar
         *
         * @factory("\YoannRenard\PHPUnitAnnotation\TestCase\Mock\Bar", params={"fooMock"})
         */
        protected $bar;
    }

will replace

    <?php
    use Prophecy\Prophecy\ObjectProphecy;
    use PHPUnit\Framework\TestCase;

    class MyClassTest extends TestCase
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
        protected function setUp(): void
        {
            parent::setUp();

            $this->fooMock = $this->prophesize(Foo::class);

            $this->bar = new Bar($this->fooMock->reveal());
        }
    }

[composer]: https://getcomposer.org
