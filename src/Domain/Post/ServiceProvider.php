<?php

namespace App\Domain\Post;

use App\Infrastructure\Container\ContainerInterface;
use App\Infrastructure\Providers\ServiceProvider as ServiceProviderInterface;
use App\Infrastructure\Support\Disk\Disk;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container): void
    {
        $container->bind(
            PostRepository::class,
            fn () : PostRepository => new PostRepository($container->make(PostFactory::class), $container->make(Disk::class))
        );
    }
}
