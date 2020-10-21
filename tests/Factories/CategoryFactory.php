<?php

namespace Tests\Factories;

use App\Domain\Post\CategoryFactory as BaseFactory;

class CategoryFactory extends TestFactory
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
            'name' => 'Test Category'
        ];
    }
}
