<?php

namespace App\Infrastructure\Support\Disk;

use App\Infrastructure\Support\Collection\Collection;
use App\Infrastructure\Support\Str;

use DirectoryIterator;

class LocalDisk implements Disk
{
    private string $root;

    public function __construct(string $root)
    {
        $this->root = rtrim($root, '/') . '/';
    }

    /**
     * @return Collection<string, File>
     */
    public function files(string $path = ''): Collection
    {
        $generator = fn () : DirectoryIterator => new DirectoryIterator($this->path($path));

        return Collection::from($generator)->filter->isFile()
                                           ->map->getPathName()
                                           ->mapInto(File::class);
    }

    public function file(string $path) : File
    {
        return new File($this->path($path));
    }

    public function save(string $path, string $content) : void
    {
        file_put_contents($this->path($path), $content);
    }

    protected function path(string $path): string
    {
        return Str::prefix($path, $this->root);
    }
}
