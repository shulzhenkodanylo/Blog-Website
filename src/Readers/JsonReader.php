<?php

declare(strict_types=1);

namespace Task4Blog\Readers;

class JsonReader implements DataReaderInterface
{
    public function read(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException('Posts path does not exist');
        }
        $data = file_get_contents($filePath);
        if ($data === false) {
            throw new \RuntimeException('Failed to read json file');
        }
        return $data;
    }
}
