<?php

declare(strict_types=1);

namespace Controllers;

use _PHPStan_ac6dae9b0\Symfony\Component\String\Exception\RuntimeException;
use Task4Blog\Handlers\PostsHandler;
use Task4Blog\Renders\Renderer;
use Task4Blog\Uploads\ImageUploader;
use Task4Blog\View\PostView;

class JsonPostsController
{
    private PostsHandler $postsHandler;
    private Renderer $renderer;
    private ImageUploader $imageUploader;
    public function __construct(PostsHandler $postsHandler, Renderer $renderer, ImageUploader $imageUploader)
    {
        $this->postsHandler = $postsHandler;
        $this->renderer = $renderer;
        $this->imageUploader = $imageUploader;
    }
    public function showPosts(): string
    {
        $posts = $this->postsHandler->getJsonPosts();
        $view = new PostView(...$posts);
        return $this->renderer->renderTwig('index.html.twig', $view);
    }

    public function storePost(array $postData, array $files): string
    {
        $postData['img'] = $this->imageUploader->upload($files['img']);

        $result = $this->postsHandler->addJsonPost($postData);
        if ($result !== 'Success') {
            throw new RuntimeException('Add post failed');
        }

        header("Location: /");
        exit;
    }
}
