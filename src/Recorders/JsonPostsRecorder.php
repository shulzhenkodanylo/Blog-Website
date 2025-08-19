<?php

declare(strict_types=1);

namespace Task4Blog\Recorders;

class JsonPostsRecorder implements DataRecorderInterface
{
    public function record(array $newPostData, string $file): string
    {
        if (!file_exists($file) || !is_readable($file)) {
            return "File does not exist or is not readable";
        }

        $json = json_decode(file_get_contents($file), true);
        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            return 'File is not a valid JSON' . json_last_error_msg();
        }

        if (!is_array($json)) {
            $json = ['posts' => []];
        }

        $json['posts'][] = $newPostData;

        $encodedData = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if (!file_put_contents($file, $encodedData, LOCK_EX)) {
            return ('Failed record data to file');
        } else {
            return 'Success';
        }
    }
}
