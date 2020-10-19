<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        foreach ($this->getTraits() as $trait) {
            if (method_exists($this, $method = preg_replace('/^[\\\\A-z]*\\\\/', 'setup', $trait))) {
                $this->{$method}();
            }
        }
    }

    private function getTraits(): array
    {
        $reducer = fn (array $acc, string $e): array => array_merge($acc, array_values(class_uses($e)));
        
        return array_unique(array_reduce(class_parents($this), $reducer, []));
    }
}
