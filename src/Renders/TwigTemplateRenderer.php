<?php

declare(strict_types=1);

namespace Task4Blog\Renders;

use Task4Blog\View\ViewInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TwigTemplateRenderer
{
    /** @var Environment $twig */
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $templateName
     * @param ViewInterface $view
     * @return string
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getTemplate(string $templateName, ViewInterface $view): string
    {

        if (!method_exists($view, 'getPostsFromView')) {
            throw new LoaderError("View doesn't have a getPostsFromView method");
        }
        $viewArray['posts'] = $view->getPostsFromView();

        return $this->twig->render($templateName, $viewArray);
    }
}
