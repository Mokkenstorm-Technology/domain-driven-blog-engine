<?php

namespace Tests\Unit\Collection;

use App\Infrastructure\Support\Collection;

$data = Collection::from([
    new Foo('foo'),
    new Foo('bar'),
    new Foo('baz'),
]);

$mapper = fn (Foo $e): string => $e->getFoo();
$filter = fn (Foo $e): bool => $e->isBa(); 

it('should map values using callbacks', fn () =>
    expect($data->map($mapper)->toArray())->toEqual(['Foo: foo', 'Foo: bar', 'Foo: baz'])
);

it('should map values using methods',
    fn () => expect($data->map->getFoo()->toArray())->toEqual(['Foo: foo', 'Foo: bar', 'Foo: baz'])
);

it('should map values using properties',
    fn () => expect($data->map->foo->toArray())->toEqual(['foo', 'bar', 'baz'])
);

it('should filter values using callbacks',
    fn () => expect($data->filter($filter)->map->foo->toArray())->toEqual(['bar', 'baz'])
);

it('should filter values using methods',
    fn () => expect($data->filter->isBa()->map->foo->toArray())->toEqual(['bar', 'baz'])
);

it('should filter values using properties',
    fn () => expect($data->filter->getFoo()->map->foo->toArray())->toEqual(['foo', 'bar', 'baz'])
);

class Foo
{
    public string $foo;

    public function __construct(string $foo)
    {
        $this->foo = $foo; 
    }

    public function getFoo(): string
    {
        return 'Foo: ' . $this->foo; 
    }

    public function isBa(): bool
    {
        return preg_match('/ba/', $this->foo);
    }
}
