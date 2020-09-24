<?php

namespace Tests\Unit\Resolvers;

use App\Infrastructure\Container\Resolvers\{AbstractResolver, ResolverAggregate};

use App\Infrastructure\Exception\ShouldNotHappen;

use ReflectionClass;
use ReflectionParameter;

$class = new class { public function foo(Foo $foo) {}};

$parameter = (new ReflectionClass($class))->getMethod('foo')->getParameters()[0];

$resolver = new ResolverAggregate;

$fooResolver = new class extends AbstractResolver
{
    public function resolve(ReflectionParameter $param)
    {
        return 'foo';
    }
};

it('should always by run', fn () =>
    $this->assertTrue($resolver->shouldUse($parameter))
);

it('should not throw an exception if a resolver was found', fn () =>
    $this->assertEquals('foo', (new ResolverAggregate($fooResolver))->resolve($parameter))
);

it('should throw an exception if no resolver was found', fn () =>
    $resolver->resolve($parameter)
)->throws(ShouldNotHappen::class);
