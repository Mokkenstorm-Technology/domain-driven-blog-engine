<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

use App\Infrastructure\Support\Collection\Collection;

class Post extends Entity
{
    protected string $title;

    protected array $fields = ['id', 'title'];

    public function __construct(EntityId $id, string $title)
    {
        parent::__construct($id);

        $this->title = $title;
    }
}
