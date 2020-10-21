<?php

namespace Tests\Domain;

use App\Domain\Post\Post;
use App\Domain\Post\Category;
use App\Domain\Post\Comment;

use App\Infrastructure\Entity\EntityId;
use App\Infrastructure\Exception\NotFound;

it('should be able to create posts', function () {
    $post = $this->create(Post::class);

    $this->assertTrue($this->repository(Post::class)->find($post->getId())->equals($post));
});

it('should be able to fetch all posts', function () {
    $this->assertContainsOnlyInstancesOf(Post::class, $this->repository(Post::class)->all());
});

it('should fail on unknown posts', function () {
    $this->repository(Post::class)->find(EntityId::create());
})->throws(NotFound::class);

it('should fail on unsaved posts', function () {
    $this->repository(Post::class)->find($this->make(Post::class)->getId());
})->throws(NotFound::class);

it('should not have any comments by default', function () {
    $this->assertCount(0, $this->make(Post::class)->comments());
});

it('should be able to add comments to a post', function () {
    $post = $this->make(Post::class);

    $this->assertCount(0, $post->comments());

    $post->addComment($this->make(Comment::class));

    $this->assertCount(1, $post->comments());
});

it('should be to save a post with comments', function () {
    $post = $this->make(Post::class)
                 ->addComment($this->make(Comment::class))
                 ->addComment($this->make(Comment::class));

    $this->save($post);

    $fetched = $this->find(Post::class, $post->getId());

    $this->assertInstanceOf(Post::class, $fetched);
    $this->assertContainsOnlyInstancesOf(Comment::class, $fetched->comments());
    $this->assertCount(2, $fetched->comments());
});

it('should be able to have a category', function () {
    $post = $this->make(Post::class)
                 ->addCategory($this->make(Category::class));

    $this->save($post);

    $fetched = $this->find(Post::class, $post->getId());

    $this->assertInstanceOf(Post::class, $fetched);
    $this->assertContainsOnlyInstancesOf(Category::class, $fetched->categories());
    $this->assertCount(1, $fetched->categories());
});
