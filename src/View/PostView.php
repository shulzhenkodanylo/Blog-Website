<?php

declare(strict_types=1);

namespace Task4Blog\View;

use Task4Blog\Models\Post;

class PostView implements ViewInterface
{
    /**
     * @var Post[] $posts
     */
    private array $posts;

    /**
     * @param Post ...$posts
     */
    public function __construct(Post ...$posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return Post[]
     */
    public function getPostsFromView(): array
    {
        return $this->posts;
    }
}
