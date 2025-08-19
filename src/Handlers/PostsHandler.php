<?php

declare(strict_types=1);

namespace Task4Blog\Handlers;

use Task4Blog\Decoders\DataDecoderInterface;
use Task4Blog\Models\PostFactory;
use Task4Blog\Readers\DataReaderInterface;
use Task4Blog\Recorders\DataRecorderInterface;

class PostsHandler
{
    private string $_postsPath;
    private DataReaderInterface $_dataReader;
    private DataDecoderInterface $_dataDecoder;
    private DataRecorderInterface $_dataRecorder;

    public function __construct(string $postsPath, DataReaderInterface $dataReader, DataDecoderInterface $dataDecoder, DataRecorderInterface $dataRecorder)
    {
        $this->_postsPath = $postsPath;
        $this->_dataReader = $dataReader;
        $this->_dataDecoder = $dataDecoder;
        $this->_dataRecorder = $dataRecorder;
    }



    public function getJsonPosts(): array
    {
        /**
 * @var array{posts: array<array<string, mixed>>} $data
*/
        $data = $this->_dataDecoder->decode($this->_dataReader->read($this->_postsPath));

        return array_map([PostFactory::class, 'create'], $data['posts']);
    }
    public function addJsonPost(array $postData): string
    {
        $newPost = [
            'id' => uniqid(),
            'author' => $postData['author'],
            'title' => $postData['title'],
            'content' => $postData['content'],
            "date" => date('Y-m-d'),
            "img" => $postData['img']
        ];
        foreach ($newPost as $key => $value) {
            if ($key !== 'img' && $value == '') {
                return 'Field "' . $key . '" is required.';
            }
        }
        return $this->_dataRecorder->record($newPost, $this->_postsPath);
    }
}
