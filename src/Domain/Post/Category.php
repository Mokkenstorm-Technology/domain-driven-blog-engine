<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

class Category extends Entity
{
    protected string $name;

    protected array $fields = [
        'name'
    ];

    public function __construct(EntityId $id, string $name)
    {
        parent::__construct($id);

        $this->name = $name;
    }
}
