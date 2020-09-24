<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\{Entity, EntityId};

use App\Infrastructure\Exception\NotFound;
use ErrorException;
use Traversable;

/**
 * @template T of Entity
 * @implements Repository<T>
 */
abstract class FileRepository implements Repository
{
    protected string $location;

    /**
     * @var class-string<T>
     */
    protected string $entityClass;

    /**
     * @return Traversable<T>
     */
    public function all(): Traversable
    {
        foreach (new \DirectoryIterator($this->basePath()) as $file) {
            /**
             * @var string
             */
            $path = $file->getRealPath();

            $entity = $this->entityFromFile($path);
            
            if ($entity !== null) {
                yield $entity;
            }
        }
    }

    /**
     * @return T
     */ 
    public function find(EntityId $id): Entity
    {
        if (!$entity = $this->entityFromFile($this->getPath($id))) {
            throw new NotFound; 
        } 
    
        return $entity;
    }

    /**
     * @return T
     */ 
    public function save(Entity $post): Entity
    {
        file_put_contents($this->getPath($post->getId()), json_encode($post));

        return $this->find($post->getId());
    }

    private function getPath(EntityId $id) : string
    {
        return $this->basePath() . ((string) $id) . ".json";
    }

    private function basePath(): string
    {
        if (!is_dir($path = __DIR__ . '/../../../storage/' . $this->location . '/')) {
            mkdir($path);
        }
        
        return $path;
    }

    /**
     * @param string $path
     * @return T | null
     */
    private function entityFromFile(string $path): ?Entity
    {
        try {
            $data = file_get_contents($path);
        } catch (ErrorException $e) {
            return null; 
        }

        if ($data === false) {
            return null;
        }

        $data = json_decode($data, true);

        $class = $this->entityClass;

        return new $class(EntityId::make($data['id']), $data['title']);
    }
}
