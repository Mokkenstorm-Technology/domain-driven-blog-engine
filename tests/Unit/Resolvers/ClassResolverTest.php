<?php

namespace Tests\Unit\Resolvers;

use App\Infrastructure\Container\Resolvers\ClassResolver;

use App\Infrastructure\Exception\ShouldNotHappen;

use ReflectionClass;

class Foo {}

$class = new class { public function foo(Foo $foo, string $bar, $baz) {}};

$parameters = (new ReflectionClass($class))->getMethod('foo')->getParameters();

[$object, $scalar, $untyped] = $parameters;

$resolver = new ClassResolver;

it('should not throw an exception for scalar values', fn () =>
    $this->assertInstanceOf(Foo::class, $resolver->resolve($object))
);

it('should throw an exception for scalar values', fn () =>
    $resolver->resolve($scalar)
)->throws(ShouldNotHappen::class);

it('should throw an exception for untyped values', fn () =>
    $resolver->resolve($untyped)
)->throws(ShouldNotHappen::class);
