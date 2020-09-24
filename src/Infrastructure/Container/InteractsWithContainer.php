<?php

declare(strict_types=1);

namespace App\Infrastructure\Container;

trait InteractsWithContainer
{
    protected function getContainer(): ContainerInterface
    {
        return Container::getInstance(); 
    }
}
