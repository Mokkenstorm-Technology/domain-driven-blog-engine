<?php

namespace Tests\Unit\Collection;

use App\Infrastructure\Support\Collection;

$integers = Collection::from([1, 2, 3]);

$strings  = Collection::from(['foo', 'bar', 'baz']);

it('should work withouta value', fn () =>
    expect(Collection::from()->toArray())->toEqual([])
);

it('should work with empty arrays', fn () =>
    expect(Collection::from([])->toArray())->toEqual([])
);

it('should work with generators', fn () =>
    expect(Collection::from(fn () => yield from $integers)->toArray())->toEqual([1, 2, 3])
);

it('should map values', fn () =>
    expect($integers->map(fn ($e) => $e * 2)->toArray())->toEqual([2, 4, 6])
);

it('should filter values', fn () =>
    expect($integers->filter(fn ($e) => $e % 2)->toArray())->toEqual([1, 3])
);

it('should reduce values', fn () =>
    expect($integers->reduce(fn (int $acc, int $e): int => $acc + $e, 0))->toEqual(6)
);

it('should chain operations', fn () => 

    expect(($integers)
        ->map(fn (int $e): int => $e * 3)
        ->filter(fn (int $e): int => !($e % 2))
        ->reduce(fn (int $sum, int $e): int => $sum + $e, 0)
    )->toEqual(6)

);
