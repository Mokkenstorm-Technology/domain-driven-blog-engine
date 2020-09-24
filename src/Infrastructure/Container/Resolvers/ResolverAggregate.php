<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Resolvers;

use App\Infrastructure\Exceptions\ShouldNotHappen;

use ReflectionParameter;
use ReflectionNamedType;

class ResolverAggregate extends AbstractResolver
{
    /**
     * @var ResolvesDependencies[]
     */
    private array $resolvers = [];

    public function __construct(ResolvesDependencies ... $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    /**
     * @return mixed
     */
    public function resolve(ReflectionParameter $param)
    {
        foreach ($this->resolvers as $resolver) {
            
            if ($resolver->shouldUse($param)) {
                return $resolver->resolve($param);
            }
        
        }

        $this->throw($this->E_NO_RESOLVER, $param);
    } // @codeCoverageIgnore
}
