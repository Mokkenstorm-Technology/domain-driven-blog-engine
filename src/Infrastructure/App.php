<?php

namespace App\Infrastructure;

use App\Infrastructure\Providers\{DiskProvider, ServiceProvider};

use App\Infrastructure\{Container\ContainerInterface, Support\Collection};

class App
{
    /**
     * @var class-string<ServiceProvider>[]
     */
    private array $providers = [
        DiskProvider::class 
    ];

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function boot(): void
    {
        Collection::from($this->providers)
            ->map(fn($e) : ServiceProvider => new $e)
            ->map->register($this->container)
            ->toArray();
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
