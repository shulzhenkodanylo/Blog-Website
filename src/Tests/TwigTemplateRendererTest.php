<?php

declare(strict_types=1);

namespace Task4Blog\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Task4Blog\Models\Post;
use Task4Blog\Renders\TwigTemplateRenderer;
use Task4Blog\View\PostView;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

class TwigTemplateRendererTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTwigRendering(): void
    {
        $postObjectMock = $this->createMock(Post::class);
        $postObjectMock->method('getId')->willReturn(1);
        $postObjectMock->method('getTitle')->willReturn('Title TESTING');
        $postObjectMock->method('getContent')->willReturn('Content TESTING');
        $postObjectMock->method('getDate')->willReturn(new \DateTimeImmutable('2020-01-01'));


        $viewMock = $this->createMock(PostView::class);
        $twigConfig = Yaml::parseFile(__DIR__ . '/../../twig.yaml');

        $templateName = 'index.html.twig';
        $templateContent = <<<TWIG
        {% for post in posts %}
          <h2>{{ post.getTitle() }}</h2>
          <p>{{ post.getContent() }}</p>
          <p>{{ post.getDate().format('Y-m-d') }}</p>
        {% endfor %}
        TWIG;

        $templateClient = new Source($templateContent, $templateName);

        //        $loader = new FilesystemLoader($templateContent);
        $loader = $this->createMock(LoaderInterface::class);
        $loader->method('getSourceContext')
            ->willReturn($templateClient);

        $twig = new Environment($loader, $twigConfig);


        $twigRenderer = new TwigTemplateRenderer($twig);

        $viewMock->method('getPostsFromView')
            ->willReturn([$postObjectMock]);

        try {
            $result = $twigRenderer->getTemplate($templateName, $viewMock);
        } catch (LoaderError | SyntaxError | RuntimeError $e) {
            $this->assertInstanceOf(LoaderError::class, $e);
            return;
        }

        $this->assertStringContainsString("Title TESTING", $result);
        $this->assertStringContainsString("Content TESTING", $result);
        $this->assertStringContainsString("2020-01-01", $result);
    }
}
