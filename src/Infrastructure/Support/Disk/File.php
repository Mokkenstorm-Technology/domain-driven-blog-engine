<?php

namespace App\Infrastructure\Support\Disk;

use ErrorException;

class File
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    public function name(): string
    {
        $pieces = explode('/', $this->path);

        $count = count($pieces);

        return $count ? $pieces[$count - 1] : '';
    }

    public function content(): string
    {
        try {
            $content = file_get_contents($this->path);
        } catch (ErrorException $e) {
            throw new FileAccessException;
        }

        if ($content === false) {
            throw new FileAccessException;
        }
        
        return $content;
    }
}
