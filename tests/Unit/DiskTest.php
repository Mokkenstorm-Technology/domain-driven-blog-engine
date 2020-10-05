<?php

namespace Tests\Unit;

use App\Infrastructure\Support\Disk\File;
use App\Infrastructure\Support\Disk\FileAccessException;

beforeEach(fn () => $this->old_reporting = error_reporting(E_ALL));
    
afterEach(fn () => error_reporting($this->old_reporting));

it('should be able to open files', function () {
    $path = __DIR__ . '/../../storage/test.txt';

    file_put_contents($path, 'Foo');

    $this->assertEquals('Foo', (new File($path))->content());

    unlink($path);
});

it('should fail on unknown files', fn () => (new File('foo'))->content())
->throws(FileAccessException::class);

it('should fail on unknown files even with shitty warning config', function () {
    $settings = error_reporting(E_ERROR | E_PARSE);

    (new File('foo'))->content();
})->throws(FileAccessException::class);
