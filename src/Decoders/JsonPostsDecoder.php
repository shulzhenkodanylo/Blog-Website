<?php

declare(strict_types=1);

namespace Task4Blog\Decoders;

class JsonPostsDecoder implements DataDecoderInterface
{
    public function decode(string $data): array
    {
        $decodedData = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(json_last_error_msg());
        }
        if (!is_array($decodedData)) {
            throw new \RuntimeException('Posts data must be an array');
        }
        foreach ($decodedData['posts'] as $post) {
            if (!isset($post['id'], $post['author'], $post['title'], $post['content'], $post['date'], $post['img'])) {
                throw new \RuntimeException('Posts data missing' . json_encode($post));
            }
        }
        return $decodedData;
    }
}
