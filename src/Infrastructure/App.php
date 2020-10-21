<?php

namespace App\Infrastructure;

use App\Infrastructure\Providers\DiskProvider;
use App\Infrastructure\Providers\ServiceProvider;

use App\Infrastructure\Container\ContainerInterface;
use App\Infrastructure\Support\Collection\Collection;

use App\Domain\Post\ServiceProvider as PostServiceProvider;

class App
{
    /**
     * @var class-string<ServiceProvider>[]
     */
    private array $providers = [
        DiskProvider::class,
        PostServiceProvider::class,
    ];

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function boot(): void
    {
        Collection::from($this->providers)
            ->map(fn (string $e) : ServiceProvider => new $e)
            ->each(function (ServiceProvider $provider) {
                $provider->register($this->container);
            });
    }

    /**
     * @template T
     * @param class-string<T> $target
     * @return T
     */
    public function make(string $target)
    {
        return $this->container->make($target);
    }
}
