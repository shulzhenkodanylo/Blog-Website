<?php

namespace Task4Blog\Readers;

interface DataReaderInterface
{
    public function read(string $filePath): string;
}
