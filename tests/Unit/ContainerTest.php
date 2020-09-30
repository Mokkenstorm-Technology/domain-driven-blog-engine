<?php

namespace Tests\Unit;

use App\Infrastructure\Container\Container;

beforeEach(fn() => $this->container = Container::getInstance());

it('should be able to resolve classes', fn () => 

    $this->assertInstanceOf(Foo::class, $this->container->make(Foo::class))

);

it('should be able to resolve classes with dependencies', fn () =>

    $this->assertInstanceOf(Bar::class, $this->container->make(Bar::class))

);

it('should be able to resolve from interfaces', function () {

   $this->container->bind(FooInterface::class, Bar::class);

   $this->assertInstanceOf(Bar::class, $this->container->make(FooInterface::class));

});

class Foo
{
    //
}

interface FooInterface
{
    public function foo(): Foo;
}

class Bar implements FooInterface
{
    private Foo $foo;

    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }

    public function foo(): Foo
    {
        return $this->foo;
    }
}
