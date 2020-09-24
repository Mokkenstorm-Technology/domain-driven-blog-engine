<?php

declare(strict_types=1);

namespace App\Infrastructure\Container;

use ReflectionClass;
use ReflectionParameter;

use App\Infrastructure\Container\Resolvers\{
    ClassResolver,
    FallbackResolver,
    ResolverAggregate,
    ResolvesDependencies
};

class Container implements ContainerInterface
{
    /**
     * @var array<class-string, class-string>
     */
    private array $bindings = [];

    /**
     * @var class-string<ResolvesDependencies>[]
     */
    protected static array $resolvers = [
        ClassResolver::class, 
        FallbackResolver::class, 
    ]; 

    protected static Container $instance;

    private ResolvesDependencies $resolver;

    private function __construct(ResolvesDependencies $resolver)
    {
        $this->resolver = $resolver;
    }

    public static function getInstance() : self
    {
        return self::$instance ?? self::$instance = self::createInstance(); 
    }

    /**
     * @template T
     * @param class-string<T> $target
     * @return T
     */
    public function make(string $target)
    {
        $target = $this->getClassForTarget($target);

        $args = array_reduce(
            $this->getConstructorArguments($target),
            fn (array $args, ReflectionParameter $param) : array =>
                array_merge($args, [$this->resolver->resolve($param)]),
            []
        );

        return new $target(...$args);
    }

    /**
     * @param class-string $interface
     * @param class-string $class
     */
    public function bind(string $interface, string $class): void
    {
        $this->bindings[$interface] = $class;
    }

    /**
     * @param class-string $class
     * @return class-string
     */
    private function getClassForTarget(string $class): string
    {
        return $this->bindings[$class] ?? $class;
    }

    /**
     * @param class-string $class
     * @return ReflectionParameter[]
     */
    private function getConstructorArguments(string $class): array
    {
        $constructor = (new ReflectionClass($class))->getConstructor();
        
        return $constructor !== null ? $constructor->getParameters() : [];
    }

    private static function createInstance() : self
    {
        return new self(new ResolverAggregate(...array_map(
            fn (string $class): ResolvesDependencies => new $class,
            self::$resolvers 
        )));
    }
}
