<?php

declare(strict_types=1);

namespace Task4Blog\Renders;

use Task4Blog\View\ViewInterface;

class Renderer
{
    private TwigTemplateRenderer $twigView;

    public function __construct(TwigTemplateRenderer $twigView)
    {
        $this->twigView = $twigView;
    }
    public function renderTwig(string $template, ViewInterface $view): string
    {
        return $this->twigView->getTemplate($template, $view);
    }
}
