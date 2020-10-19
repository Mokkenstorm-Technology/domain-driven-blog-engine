<?php

namespace Tests\Domain;

use App\Domain\Post\Post;
use App\Domain\Post\Comment;

use App\Infrastructure\Entity\EntityId;
use App\Infrastructure\Exception\NotFound;

it('should be able to create posts', function () {
    $post = $this->make(Post::class);

    $this->assertTrue($this->repository(Post::class)->find($post->getId())->equals($post));
});

it('should be able to fetch all posts', function () {
    $this->repository(Post::class)->all()->each(fn ($post) => $this->assertInstanceOf(Post::class, $post));
});

it('should fail on unknown posts', function () {
    $this->repository(Post::class)->find(EntityId::create());
})->throws(NotFound::class);

it('should fail on unsaved posts', function () {
    $this->repository(Post::class)->find($this->factory(Post::class)->create(['title' => 'Test Title'])->getId());
})->throws(NotFound::class);
