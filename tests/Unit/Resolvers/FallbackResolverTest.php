<?php

namespace Tests\Unit\Resolvers;

use App\Infrastructure\Container\Resolvers\FallbackResolver;

use App\Infrastructure\Exception\ShouldNotHappen;

use ReflectionClass;

$class = new class { public function foo(Foo $foo) {}};

$parameter = (new ReflectionClass($class))->getMethod('foo')->getParameters()[0];

$resolver = new FallbackResolver;

it('should always by run', fn() => $this->assertTrue($resolver->shouldUse($parameter)));

it('should always throw an exception', fn() => $resolver->resolve($parameter))
    ->throws(ShouldNotHappen::class);
