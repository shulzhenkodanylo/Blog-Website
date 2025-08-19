<?php

declare(strict_types=1);

namespace Task4Blog\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Task4Blog\Renders\Renderer;
use Task4Blog\Renders\TwigTemplateRenderer;
use Task4Blog\View\PostView;

class RendererTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRenderTwig(): void
    {
        $templateFile = 'test.html.twig';
        $templateContent = '<h1>Blog Task TESTING</h1>';

        $viewMock = $this->createMock(PostView::class);


        $twigRendererMock = $this->createMock(TwigTemplateRenderer::class);
        $twigRendererMock->expects($this->once())
            ->method('getTemplate')
            ->with($templateFile, $viewMock)
            ->willReturn($templateContent);

        $renderer = new Renderer($twigRendererMock);


        $this->assertEquals($templateContent, $renderer->renderTwig($templateFile, $viewMock));
    }
}
