<?php

namespace Tests\Plugin\Files;

use App\Infrastructure\Support\Collection;

(new Collection([ new Foo ]))->map->foo()->toArray();

(new Collection([ new Foo ]))->map->value->toArray();

(new Collection([ new Foo ]))->map->value->mapInto(Bar::class)->map->value->toArray();

(new Collection([ new Foo ]))->map->value->mapInto(Bar::class)->map->bar()->toArray();

(new Collection([ new Foo ]))->filter(fn () : bool => true)->map->foo()->toArray();

Collection::from([ new Foo ])->map->foo()->toArray();

Collection::from([ new Foo ])->map->value->toArray();

Collection::from([ new Foo ])->map->value->mapInto(Bar::class)->map->value->toArray();

Collection::from([ new Foo ])->map->value->mapInto(Bar::class)->map->bar()->toArray();

Collection::from([ new Foo ])->filter(fn () : bool => true)->map->foo()->toArray();