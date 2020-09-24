<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Resolvers;

use ReflectionParameter;

class FallbackResolver extends AbstractResolver
{
    /**
     * @return mixed
     */
    public function resolve(ReflectionParameter $param)
    {
        $this->throw($this->E_UNRESOLVABLE_PARAMETER, $param);
    } // @codeCoverageIgnore
}
