<?php

namespace Tests;

use IteratorAggregate;
use Traversable;

class Dataset implements IteratorAggregate
{
    private array $values;

    private function __construct(array $data)
    {
        $this->values = array_map(fn ($e) : array => [$e], $data);
    }

    public static function from(array $data): self
    {
        return new self($data);
    }

    public function parameter($parameter): self
    {
        $this->values = array_map(fn ($e) => array_merge($e, [ $parameter ]), $this->values);
        
        return $this;
    }

    public function parameters(array $parameters): self
    {
        foreach ($parameters as $index => $parameter) {
            $this->values[$index][] = $parameter;
        }

        return $this;
    }

    public function expect(array $expectations): self
    {
        return $this->parameters($expectations);
    }

    public function getIterator(): Traversable
    {
        return yield from $this->values;
    }

    public function __call(string $method, array $parameters)
    {
        return $this;
    }
}
