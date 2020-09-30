<?php

namespace Tests\Plugin\Files;

class Bar
{
    public string $value;

    public function __construct(string $value = 'bar')
    {
        $this->value = $value; 
    }

    public function bar(): string
    {
        return $this->value; 
    }
}
