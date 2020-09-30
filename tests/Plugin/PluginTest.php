<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use App\Infrastructure\Support\Collection;
use App\Infrastructure\Support\HigherOrderCollectionProxy;

class PluginTest extends TestCase
{
    public function testValidCases(): void
    {
        $results = $this->analyse('ValidCalls');

        if ($results) {
            $this->fail(sprintf("%s %s", $results[0]['line'], $results[0]['message']));
        }

        $this->assertEmpty($results);
    }

    public function testInValidCases(): void
    {
        $expectedErrors = [
            7 => "Call to an undefined method App\Infrastructure\Support\HigherOrderCollectionProxy<Tests\Plugin\Files\Foo, string>::bar().",
            9 => "Call to an undefined method App\Infrastructure\Support\HigherOrderCollectionProxy<Tests\Plugin\Files\Foo, string>::bar()." 
        ];

        $actualErrors = array_reduce(
            $this->analyse('InvalidCalls'),
            fn (array $acc, array $error): array => $acc + [ $error['line'] => $error['message'] ],
            []
        );
    
        $this->assertEquals($expectedErrors, $actualErrors);
    }

    /**
     * @return string[]
     */
    protected function analyse(string $file): array
    {
        $configPath = __DIR__. '/../../phpstan.neon';
        
        $command = escapeshellcmd(__DIR__.'/../../vendor/bin/phpstan');

        $file = __DIR__ . '/Files/' . $file . '.php'; 

        $bootstrap = __DIR__ . '/Files/bootstrap.php'; 

        exec(
            sprintf(
                '%s %s analyse --no-progress  --level=max --configuration %s  %s --error-format=%s',
                escapeshellarg(PHP_BINARY), $command,
                escapeshellarg($configPath),
                escapeshellarg($file),
                'json'
            ),
            $jsonResult
        );

        return json_decode($jsonResult[0], true)['files'][$file]['messages'] ?? [];
    }
}
