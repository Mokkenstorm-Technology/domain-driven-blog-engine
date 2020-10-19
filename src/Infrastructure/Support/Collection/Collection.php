<?php

namespace App\Infrastructure\Support\Collection;

use Traversable;
use IteratorAggregate;
use JsonSerializable;

use InvalidArgumentException;

/**
 * @template K
 * @template T
 *
 * @implements IteratorAggregate<K, T>
 */
class Collection implements IteratorAggregate
{
    /**
     * @var (callable(): iterable<K, T>) | iterable<K, T>
     */
    private $source;

    /**
     * @param (callable(): iterable<K, T>) | iterable<K, T> $source
     */
    public function __construct($source = [])
    {
        $this->source = $source;
    }
    
    /**
     * @template KS
     * @template KT
     *
     * @param (callable(): iterable<KS, KT>) | iterable<KS, KT> $source
     * @return self<KS, KT>
     */
    public static function from($source = [])
    {
        return new self($source);
    }
    
    /**
     * @return Traversable<K, T>
     */
    public function getIterator(): Traversable
    {
        $source = $this->source;

        yield from (is_callable($source) ? $source() : $source);
    }

    /**
     * @return array<K, T>
     */
    public function toArray(): array
    {
        return iterator_to_array($this);
    }

    /**
     * @return T[]
     */
    public function toList(): array
    {
        return iterator_to_array($this->values());
    }

    /**
     * @template S
     * @param callable(T, K): S $mapper
     * @return self<K, S>
     */
    public function map(callable $mapper): self
    {
        return new self(function () use ($mapper) {
            foreach ($this as $key => $element) {
                yield $key => $mapper($element, $key);
            }
        });
    }

    /**
     * @param callable(T, K): bool $filter
     * @return self<K, T>
     */
    public function filter(callable $filter): self
    {
        return new self(function () use ($filter) {
            foreach ($this as $key => $element) {
                if ($filter($element, $key)) {
                    yield $key => $element;
                }
            }
        });
    }

    /**
     * @template S
     *
     * @param callable(S, T, K): S $reducer
     * @param S $initial
     * @return S
     */
    public function reduce(callable $reducer, $initial)
    {
        foreach ($this as $key => $element) {
            $initial = $reducer($initial, $element, $key);
        }

        return $initial;
    }

    /**
     * @param callable(T, K): mixed $callback
     */
    public function each(callable $callback): void
    {
        $this->reduce(fn ($acc, $element, $key) => $callback($element, $key), null);
    }

    /**
     * @param T $item
     * @return static
     */
    public function add($item): self
    {
        return new self(function () use ($item) {
            yield from $this;
            yield $item;
        });
    }

    /**
     * @template S
     *
     * @param class-string<S> $target
     * @return self<K, S>
     */
    public function mapInto(string $target)
    {
        return $this->map(fn ($element, $key) => new $target($element, $key));
    }

    /**
     * @return self<int, T>
     */
    public function values()
    {
        $i = 0;

        foreach ($this as $value) {
            yield $i++ => $value;
        }
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return new HigherOrderCollectionProxy($this, $name);
    }

    /**
     * @return array<K, string>
     */
    public function jsonSerialize() : array
    {
        return $this->map(fn ($e, $i): string => json_encode($e, JSON_THROW_ON_ERROR))->toArray();
    }
}
