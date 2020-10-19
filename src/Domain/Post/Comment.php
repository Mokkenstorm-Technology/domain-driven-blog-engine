<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

class Comment extends Entity
{
    protected string $content;

    protected array $fields = [
        'content'
    ];

    public function __construct(EntityId $id, string $content)
    {
        parent::__construct($id);

        $this->content = $content;
    }
}
