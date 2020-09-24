<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Resolvers;

use App\Infrastructure\Container\InteractsWithContainer;

use ReflectionParameter;
use ReflectionNamedType;

class ClassResolver extends AbstractResolver
{
    use InteractsWithContainer;

    public function shouldUse(ReflectionParameter $param): bool
    {
        $type = $this->getParameterType($param);

        return $type !== null && class_exists($type->getName());
    }

    /**
     * @return mixed
     */
    public function resolve(ReflectionParameter $param)
    {
        $type = $this->getParameterType($param);
        
        if ($type === null) {
            $this->throw($this->E_UNTYPED_PARAMETER, $param);
        }

        /**
         * @var class-string
         */
        $name = $type->getName();

        if (!class_exists($name)) {
            $this->throw($this->E_SCALAR_PARAMETER, $param);
        }

        return $this->getContainer()->make($name);
    }

    /**
     * @return ReflectionNamedType | null 
     */
    private function getParameterType(ReflectionParameter $param): ? ReflectionNamedType
    {
        /**
         * @var ReflectionNamedType | null
         */
        $type = $param->getType();

        return $type;
    }
}
