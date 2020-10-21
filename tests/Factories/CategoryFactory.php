<?php

namespace Tests\Factories;

use App\Domain\Post\CategoryFactory as BaseFactory;

class CategoryFactory extends TestFactory
{
    public function __construct(BaseFactory $factory)
    {
        $this->factory = $factory;
    }

    protected function fakeData(array $data): array
    {
        return [
            'name' => 'Test Category'
        ];
    }
}
