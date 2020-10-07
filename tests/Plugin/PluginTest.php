<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use App\Infrastructure\Support\Collection;
use App\Infrastructure\Support\HigherOrderCollectionProxy;

class PluginTest extends TestCase
{
    public function testValidCases(): void
    {
        $this->assertEmpty($this->analyse('ValidCalls'));
    }

    public function testInValidCases(): void
    {
        $expectedErrors = [
            7 => "Call to an undefined method App\Infrastructure\Support\HigherOrderCollectionProxy<Tests\Plugin\Files\Foo, App\Infrastructure\Support\Collection<S>>::bar().",
            9 => "Call to an undefined method App\Infrastructure\Support\HigherOrderCollectionProxy<Tests\Plugin\Files\Foo, App\Infrastructure\Support\Collection<S>>::bar().",
            11 => "Call to an undefined method App\Infrastructure\Support\HigherOrderCollectionProxy<Tests\Plugin\Files\Bar|Tests\Plugin\Files\Foo, App\Infrastructure\Support\Collection<S>>::bar()."
        ];

        $actualErrors = array_reduce(
            $this->analyse('InvalidCalls'),
            fn (array $acc, array $error): array => $acc + [ $error['line'] => $error['message'] ],
            []
        );

        foreach ($actualErrors as $line => $error) {
            $this->assertEquals($expectedErrors[$line], $error);
        }

        foreach (array_diff_assoc($expectedErrors, $actualErrors) as $line => $error) {
            $this->fail(sprintf("Expected failure %s: %s did not occur", $line, $error));
        }
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
                '%s %s analyse --no-progress  --level=max --configuration %s  %s --error-format=%s --debug',
                escapeshellarg(PHP_BINARY),
                $command,
                escapeshellarg($configPath),
                escapeshellarg($file),
                'json'
            ),
            $jsonResult
        );

        return json_decode($jsonResult[1], true)['files'][$file]['messages'] ?? [];
    }
}
