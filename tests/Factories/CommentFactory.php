<?php

namespace Tests\Factories;

use App\Domain\Post\CommentFactory as BaseFactory;

class CommentFactory extends TestFactory
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
            'content' => 'Iorem Ipsum'
        ];
    }
}
