<?php

declare(strict_types=1);

namespace Task4Blog\Uploads;

use RuntimeException;

class ImageUploader
{
    private string $imageName;
    private string $imageTmpName;
    private string $uploadPath;
    private int $uploadMaxSize = 2 * 1024 * 1024;
    private array $allowedTypes = ["image/png", "image/jpeg", "image/jpg"];
    public function __construct(string $uploadPath)
    {
        $this->uploadPath = rtrim($uploadPath, '/') . '/';
    }

    private function isImage(string $imageTmpName): void
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $imageTmpName);
        if (!in_array($mime, $this->allowedTypes)) {
            throw new RuntimeException('Invalid file type');
        }
    }

    private function imageNameValidation(): void
    {
        $this->imageName = htmlspecialchars(uniqid() . $this->imageName, ENT_QUOTES);
    }

    private function imageSizeValidation(int $imageSize): void
    {
        if ($imageSize > $this->uploadMaxSize) {
            throw new RuntimeException('Image size is too big');
        }
    }

    private function moveFile(): void
    {
        if (!move_uploaded_file($this->imageTmpName, $this->uploadPath . $this->imageName)) {
            throw new RuntimeException('Failed to move uploaded file');
        }
    }

    public function upload(array $files): string
    {

        $this->imageName = $files['name'];
        $imageSize = $files['size'];
        $this->imageTmpName = $files['tmp_name'];

        $this->isImage($this->imageTmpName);
        $this->imageSizeValidation($imageSize);
        $this->imageNameValidation();

        $this->moveFile();

        return $this->imageName;
    }
}
