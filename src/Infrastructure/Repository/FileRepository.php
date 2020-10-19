<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;
use App\Infrastructure\Entity\Factory;

use App\Infrastructure\Exception\NotFound;
use App\Infrastructure\Support\Disk\Disk;
use App\Infrastructure\Support\Disk\File;
use App\Infrastructure\Support\Disk\FileAccessException;

use Traversable;

/**
 * @template T of Entity
 * @implements Repository<T>
 */
abstract class FileRepository implements Repository
{
    protected string $extension = '.json';

    protected string $location;

    protected Disk $disk;

    /**
     * @var Factory<T>
     */
    protected Factory $factory;

    /**
     * @param Factory<T> $factory
     */
    public function __construct(Factory $factory, Disk $disk)
    {
        $this->factory  = $factory;
        $this->disk     = $disk;
    }

    /**
     * @return Traversable<T>
     */
    public function all(): Traversable
    {
        $filter = fn (File $file) : bool => (bool) preg_match("/$this->extension$/", $file->name());

        $mapper = fn (File $file) => $this->entityFromFile($file);
            
        return $this->disk->files($this->location)->filter($filter)->map($mapper);
    }

    /**
     * @return T
     */
    public function find(EntityId $id): Entity
    {
        try {
            return $this->entityFromFile($this->disk->file($this->file($id)));
        } catch (FileAccessException $e) {
            throw new NotFound;
        }
    }

    /**
     * @return T
     */
    public function save(Entity $post): Entity
    {
        assert(($contents = json_encode($post)) !== false);

        $this->disk->save($this->file($post->getId()), $contents);
        
        return $this->find($post->getId());
    }

    private function file(EntityId $id) : string
    {
        return $this->location . '/' . ((string) $id) . ".json";
    }

    /**
     * @return T
     */
    private function entityFromFile(File $file): Entity
    {
        return $this->factory->make(json_decode($file->content(), true, JSON_THROW_ON_ERROR));
    }
}
