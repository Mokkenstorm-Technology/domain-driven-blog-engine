<?php

namespace Tests\Factories;

use App\Domain\Post\PostFactory as BaseFactory;

class PostFactory extends TestFactory
{
    /**
     * @var class-string<Factory<T>>
     */
    protected string $factoryClass = BaseFactory::class;

    /**
     * @return array<string, mixed>
     */
    protected function fakeData(): array
    {
        return [
            'title' => 'Test Title'
        ];
    }
}
