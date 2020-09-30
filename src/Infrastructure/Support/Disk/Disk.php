<?php

namespace App\Infrastructure\Support\Disk;

use App\Infrastructure\Support\Collection;

interface Disk
{
    /**
     * @return Collection<File>
     */
    public function files(string $path = ''): Collection;
    
    public function file(string $path) : File;

    public function save(string $path, string $content) : void;
}
