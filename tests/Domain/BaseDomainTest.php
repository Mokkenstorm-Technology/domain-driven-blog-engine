<?php

namespace Tests\Domain;

use Tests\TestCase;
use Tests\Concerns\CreatesEntities;
use App\Infrastructure\App;
use App\Infrastructure\Container\Container;

class BaseDomainTest extends TestCase
{
    use CreatesEntities;

    protected function setUp(): void
    {
        $this->app = (new App(Container::getInstance()));

        $this->app->boot();

        parent::setUp();
    }
}
