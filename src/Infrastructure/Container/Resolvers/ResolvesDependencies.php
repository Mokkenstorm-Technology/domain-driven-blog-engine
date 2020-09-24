<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Resolvers;

use ReflectionParameter;

interface ResolvesDependencies
{
    /**
     * @return bool
     */
    public function shouldUse(ReflectionParameter $param): bool;

    /**
     * @return mixed
     */
    public function resolve(ReflectionParameter $param);
}
