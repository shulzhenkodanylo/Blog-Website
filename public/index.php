<?php

declare(strict_types=1);

use Controllers\JsonPostsController;
use Symfony\Component\Yaml\Yaml;
use Task4Blog\Decoders\JsonPostsDecoder;
use Task4Blog\Handlers\PostsHandler;
use Task4Blog\Readers\JsonReader;
use Task4Blog\Recorders\JsonPostsRecorder;
use Task4Blog\Renders\Renderer;
use Task4Blog\Renders\TwigTemplateRenderer;
use Task4Blog\Routers\JsonPostsRouter;
use Task4Blog\Uploads\ImageUploader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/../vendor/autoload.php';

$jsonDataPath = __DIR__ . '/../data/posts.json';

$twigConfig = Yaml::parseFile(__DIR__ . '/../twig.yaml');
$twigLoader = new FilesystemLoader(__DIR__ . '/../src/View/templates/client');

$imgUploadsPath = __DIR__ . '/img/uploads';

$twig = new Environment($twigLoader, $twigConfig);
$twig->addExtension(new DebugExtension());

$twigView = new TwigTemplateRenderer($twig);
$renderer = new Renderer($twigView);

$jsonReader = new JsonReader();
$jsonDecoder = new JsonPostsDecoder();
$jsonRecorder = new JsonPostsRecorder();

$imageUploader = new ImageUploader($imgUploadsPath);

$postHandler = new PostsHandler($jsonDataPath, $jsonReader, $jsonDecoder, $jsonRecorder);

$controller = new JsonPostsController($postHandler, $renderer, $imageUploader);

$router = new JsonPostsRouter();

$router->get('/', function () use ($controller) {
    return $controller->showPosts();
});
$router->post('/', function () use ($controller) {
    return $controller->storePost($_POST, $_FILES);
});

echo $router->resolve();
