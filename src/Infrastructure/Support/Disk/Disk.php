<?php

namespace App\Infrastructure\Support\Disk;

use App\Infrastructure\Support\Collection\Collection;

interface Disk
{
    /**
     * @return Collection<string, File>
     */
    public function files(string $path = ''): Collection;
    
    public function file(string $path) : File;

    public function save(string $path, string $content) : void;
}
