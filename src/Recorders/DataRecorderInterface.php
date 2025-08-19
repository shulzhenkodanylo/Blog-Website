<?php

namespace Task4Blog\Recorders;

interface DataRecorderInterface
{
    public function record(array $newPostData, string $file): string;
}
