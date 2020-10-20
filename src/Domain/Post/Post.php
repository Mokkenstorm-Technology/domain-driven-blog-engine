<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

use App\Infrastructure\Support\Collection\Collection;

class Post extends Entity
{
    protected PostTitle $title;

    /**
     * @var Collection<int, Comment>
     */
    protected Collection $comments;

    /**
     * @var string[]
     */
    protected array $fields = [
        'title',
        'comments'
    ];

    /**
     * @param Collection<int, Comment> $comments
     */
    public function __construct(
        EntityId $id,
        PostTitle $title,
        Collection $comments
    ) {
        parent::__construct($id);

        $this->title    = $title;
        $this->comments = $comments;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function comments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        $this->comments = $this->comments->add($comment);

        return $this;
    }
}
