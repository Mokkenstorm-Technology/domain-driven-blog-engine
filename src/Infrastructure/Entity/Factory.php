<?php

namespace App\Infrastructure\Entity;

/**
 * @template T of Entity
 */
interface Factory
{
    /**
     * @param array<mixed> $data
     * @return T
     */
    public function create(array $data = []): Entity;

    /**
     * @param array<mixed> $data
     * @return T
     */
    public function make(array $data = []): Entity;
}
