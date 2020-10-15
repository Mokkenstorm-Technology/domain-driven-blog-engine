<?php

namespace Tests\Factories;

class PostFactory extends TestFactory
{
    protected function fakeData(array $data): array
    {
        return [
            'title' => 'Test Title'
        ];
    }
}
