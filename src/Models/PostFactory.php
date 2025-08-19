<?php

declare(strict_types=1);

namespace Task4Blog\Models;

class PostFactory
{
    public static function create(array $data): Post
    {
        if (!isset($data['author'], $data['title'], $data['content'], $data['date'], $data['id'], $data['img'])) {
            throw new \RuntimeException('Missing required data');
        }
        return new Post(
            (int) $data['id'],
            (string) $data['author'],
            (string) $data['title'],
            (string) $data['content'],
            (string) $data['date'],
            (string) $data['img'],
        );
    }
}
