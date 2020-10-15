<?php

declare(strict_types=1);

namespace App\Infrastructure\Container;

use Closure;

use ReflectionClass;
use ReflectionType;
use ReflectionNamedType;
use ReflectionFunction;
use ReflectionParameter;

use App\Infrastructure\Support\Collection;

class Container implements ContainerInterface
{
    /**
     * @var array<class-string, class-string | Closure>
     */
    private array $bindings = [];

    protected static Container $instance;

    public static function getInstance() : self
    {
        return self::$instance ??= new self;
    }

    /**
     * @template T
     *
     * @param class-string<T> $target
     * @return T
     */
    public function make(string $target)
    {
        $target = $this->getBinding($target);

        $reducer = function (array $args, ? ReflectionType $type, int $key) : array {
            assert($type instanceof ReflectionNamedType);

            /**
             * @var class-string | null
             */
            $name = $type->getName();

            assert($name !== null);

            return array_merge($args, [$this->make($name)]);
        };

        /**
         * @var Collection<int, ReflectionType>
         */
        $args = $this->getConstructorArguments($target)->map->getType();

        $argumentList = $args->reduce($reducer, []);

        return is_string($target) ? new $target(...$argumentList) : $target(...$argumentList);
    }

    /**
     * @template T
     *
     * @param class-string<T> $interface
     * @param class-string<T> | Closure(): T $class
     */
    public function bind(string $interface, $class): void
    {
        $this->bindings[$interface] = $class;
    }

    /**
     * @template T
     *
     * @param class-string<T> $class
     * @return class-string<T> | Closure(): T $class
     */
    private function getBinding(string $class)
    {
        /**
         * @var class-string<T> | Closure(): T
         */
        $binding = $this->bindings[$class] ?? $class;

        return $binding;
    }

    /**
     * @param class-string | Closure $target
     * @return Collection<int, ReflectionParameter>
     */
    private function getConstructorArguments($target): Collection
    {
        $reflector = $target instanceof Closure ? new ReflectionFunction($target) : (new ReflectionClass($target))->getConstructor();
        
        return Collection::from($reflector !== null ? $reflector->getParameters() : []);
    }
}
