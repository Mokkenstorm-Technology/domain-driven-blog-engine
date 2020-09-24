<?php

namespace Tests\Domain;

use App\Domain\Post\{Post, PostFactory, PostRepository};
use App\Infrastructure\{Entity\EntityId, Exception\NotFound};

beforeEach(function () {
    $this->repository = new PostRepository;
    $this->factory    = new PostFactory;
});
    
it('should be able to create posts', function () {

    $post = $this->factory->create(['title' => 'Test Title']);
    
    $this->repository->save($post);

    $this->assertTrue($this->repository->find($post->getId())->equals($post));

});

it('should be able to fetch all posts', function () {
    foreach ($this->repository->all() as $post) {
        $this->assertInstanceOf(Post::class, $post); 
    }
});

it('should fail on unknown posts', fn () =>
    $this->repository->find(EntityId::create())
)->throws(NotFound::class);

it('should fail on unsaved posts', fn () =>
    $this->repository->find($this->factory->create(['title' => 'Test Title'])->getId())
)->throws(NotFound::class);
