<?php

namespace App\Infrastructure\Providers;

use App\Infrastructure\Container\ContainerInterface as Container;

interface ServiceProvider
{
    public function register(Container $container): void;
}
