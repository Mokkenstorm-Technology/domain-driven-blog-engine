<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Resolvers;

use App\Infrastructure\Exception\ShouldNotHappen;

use ReflectionClass;
use ReflectionParameter;

abstract class AbstractResolver implements ResolvesDependencies
{
    protected string $E_UNTYPED_PARAMETER = "%s tried to resolve untyped parameter %s for %s";
    protected string $E_SCALAR_PARAMETER = "%s tried to resolve scalar parameter %s for %s";
    protected string $E_UNRESOLVABLE_PARAMETER = "%s got Unresolvable parameter %s for class %s";
    protected string $E_UNBOUND_CLASS = "%s got parameter %s which is not bound to a class";
    protected string $E_NO_RESOLVER = "%s found no suitable resolver for parameter %s for class %s";

    public function shouldUse(ReflectionParameter $param): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    abstract public function resolve(ReflectionParameter $param);

    protected function throw(string $message, ReflectionParameter $param): void
    {
        if (($class = $param->getDeclaringClass()) === null) {

            ShouldNotHappen::throw($this->E_UNBOUND_CLASS, static::class, $param->getName());

        };

        ShouldNotHappen::throw($message, static::class, $param->getName(), $class->getName());
    } // @codeCoverageIgnore
}
