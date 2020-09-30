<?php

namespace Tests\Plugin\Files;

use App\Infrastructure\Support\Collection;

(new Collection([ new Foo ]))->map->bar()->toArray();

(new Collection([ new Foo ]))->filter()->map->bar()->toArray();
