<?php

namespace Tests\Factories;

return [
    
    \App\Domain\Post\Category::class => [
        'factory'       => CategoryFactory::class,
    ],

    \App\Domain\Post\Comment::class => [
        'factory'       => CommentFactory::class,
    ],
    
    \App\Domain\Post\Post::class => [
        'factory'       => PostFactory::class,
        'repository'    => \App\Domain\Post\PostRepository::class
    ],
];
