<?php

namespace Tests\Factories;

use App\Domain\Post\CommentFactory as BaseFactory;

class CommentFactory extends TestFactory
{
    public function __construct(BaseFactory $factory)
    {
        $this->factory = $factory;
    }

    protected function fakeData(array $data): array
    {
        return [
            'content' => 'Iorem Ipsum'
        ];
    }
}
