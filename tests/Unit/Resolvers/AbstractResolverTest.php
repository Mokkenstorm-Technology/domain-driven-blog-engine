<?php

namespace Tests\Unit\Resolvers;

use App\Infrastructure\Container\Resolvers\AbstractResolver;

use App\Infrastructure\Exception\ShouldNotHappen;

use ReflectionClass;
use ReflectionFunction;
use ReflectionParameter;

function foo(Foo $foo) {}

$reflector = new ReflectionFunction('Tests\Unit\Resolvers\foo');
$parameter = $reflector->getParameters()[0];

$resolver = new class extends AbstractResolver
{
    public function resolve(ReflectionParameter $param)
    {
        return $this->throw('foo', $param);
    }
};

it('should always by run', fn () =>
    $this->assertTrue($resolver->shouldUse($parameter))
);

it('should throw an exception for non-methods', fn () =>
    $resolver->resolve($parameter)
)->throws(ShouldNotHappen::class);
