<?php

namespace App\Infrastructure\Providers;

use App\Infrastructure\Support\Disk\Disk;
use App\Infrastructure\Support\Disk\LocalDisk;

use App\Infrastructure\Container\ContainerInterface;

class DiskProvider implements ServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        $container->bind(
            Disk::class,
            fn () : LocalDisk =>
            new LocalDisk(__DIR__ . '/../../../storage/')
        );
    }
}
