<?php

namespace Task4Blog\Decoders;

interface DataDecoderInterface
{
    public function decode(string $data): array;
}
