<?php
//
//declare(strict_types=1);
//
//namespace Task4Blog\Tests;
//
//use Controllers\JsonPostsController;
//use PHPUnit\Framework\MockObject\Exception;
//use PHPUnit\Framework\TestCase;
//use Task4Blog\Decoders\DataDecoderInterface;
//use Task4Blog\Handlers\PostsHandler;
//use Task4Blog\Readers\DataReaderInterface;
//use Task4Blog\Recorders\DataRecorderInterface;
//use Task4Blog\Renders\Renderer;
//
//class JsonPostsControllerTest extends TestCase
//{
//    /**
//     * @throws Exception
//     */
//    public function testShowPosts(): void
//    {
//        $path = "/path/to/posts";
//        $postData = [
//            'author' => 'Author',
//            'id' => uniqid(),
//            'title' => 'Title TESTING',
//            'content' => 'Content TESTING',
//            'date' => '2025-12-30',
//            'image' => 'image.jpg',
//        ];
//
//        $postString = json_encode(
//            [
//                'posts' => [$postData],
//            ]
//        );
//        $templateContent = '<h1>Title TESTING</h1><p>Content TESTING</p><p>2025-12-30</p>';
//
//        $dataReader = $this->createMock(DataReaderInterface::class);
//        $dataDecoder = $this->createMock(DataDecoderInterface::class);
//        $renderer = $this->createMock(Renderer::class);
//        $recorder = $this->createMock(DataRecorderInterface::class);
//
//        $postsHandler = new PostsHandler($path, $dataReader, $dataDecoder, $recorder);
//        $controller = new JsonPostsController($postsHandler, $renderer);
//
//        $dataReader->method('read')
//            ->with($path)
//            ->willReturn($postString);
//
//        $dataDecoder->method('decode')
//            ->with($postString)
//            ->willReturn(
//                [
//                'posts' => [$postData]
//                ]
//            );
//
//        $renderer->method('renderTwig')
//            ->willReturn($templateContent);
//
//        $result = $controller->showPosts();
//
//        $this->assertStringContainsString('Title TESTING', $result);
//        $this->assertStringContainsString('Content TESTING', $result);
//        $this->assertStringContainsString('2025-12-30', $result);
//    }
//}
