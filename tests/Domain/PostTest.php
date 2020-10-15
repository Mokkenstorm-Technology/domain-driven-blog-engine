<?php

namespace Tests\Domain;

use App\Domain\Post\Post;
use App\Domain\Post\PostRepository;

use App\Infrastructure\Entity\EntityId;
use App\Infrastructure\Exception\NotFound;

use Tests\Factories\PostFactory;

beforeEach(function () {
    $this->registerFactory(Post::class, PostFactory::class);
    $this->registerRepository(Post::class, PostRepository::class);
});

it('should be able to create posts', function () {
    $post = $this->create(Post::class);

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
