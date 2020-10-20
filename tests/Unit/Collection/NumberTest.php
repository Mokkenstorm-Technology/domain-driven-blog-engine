<?php

namespace Tests\Unit\Collection;

use App\Infrastructure\Support\Collection\Collection;

$integers = Collection::from([1, 2, 3]);

$strings  = Collection::from(['foo', 'bar', 'baz']);

it(
    'should work withouta value',
    fn () =>
    expect(Collection::from()->toList())->toEqual([])
);

it(
    'should work with empty arrays',
    fn () =>
    expect(Collection::from([])->toList())->toEqual([])
);

it(
    'should work with generators',
    fn () =>
    expect(Collection::from(fn () => yield from $integers)->toList())->toEqual([1, 2, 3])
);

it(
    'should map values',
    fn () =>
    expect($integers->map(fn ($e) => $e * 2)->toList())->toEqual([2, 4, 6])
);

it(
    'should filter values',
    fn () =>
    expect($integers->filter(fn ($e) => $e % 2)->toList())->toEqual([1, 3])
);

it(
    'should reduce values',
    fn () =>
    expect($integers->reduce(fn (int $acc, int $e): int => $acc + $e, 0))->toEqual(6)
);

it(
    'should chain operations',
    fn () =>

    expect(
        ($integers)
        ->map(fn (int $e): int => $e * 3)
        ->filter(fn (int $e): int => !($e % 2))
        ->reduce(fn (int $sum, int $e): int => $sum + $e, 0)
    )->toEqual(6)
);

it(
    'should convert to maps correctly',
    fn () => expect(
        Collection::from(['foo' => 1, 'bar' => 2, 'baz' => 3])
            ->filter(fn (int $e, string $key): bool => $key !== 'bar')
            ->toArray()
    )->toEqual(['foo' => 1, 'baz' => 3])
);

it(
    'should serialize to json correctly',
    fn () => expect(json_encode($integers))->toEqual("[1,2,3]")
);

it(
    'should be able to concatenate correctly',
    fn () => expect(Collection::from([1])->add(2)->add(3)->toArray())->toEqual([1,2,3])
);
