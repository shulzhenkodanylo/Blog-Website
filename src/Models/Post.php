<?php

declare(strict_types=1);

namespace Task4Blog\Models;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

class Post
{
    private int $_id;
    private string $_author;
    private string $_title;
    private string $_content;
    private DateTimeImmutable $_date;

    private string $_img;


    public function __construct(
        int $id,
        string $author,
        string $title,
        string $content,
        string $date,
        string $img
    ) {
        Assert::stringNotEmpty($title);
        Assert::notWhitespaceOnly($title);

        Assert::stringNotEmpty($content);
        Assert::notWhitespaceOnly($content);
        $this->_id = $id;
        $this->_author = $author;
        $this->_title = $title;
        $this->_content = $content;
        try {
            $this->_date = new DateTimeImmutable($date);
        } catch (\Exception $e) {
            throw new \RuntimeException("Couldn't create date object" . $e->getMessage());
        }
        $this->_img = $img;
    }
    /**
     * @psalm-api
     */
    public function getId(): int
    {
        return $this->_id;
    }
    public function getTitle(): string
    {
        return $this->_title;
    }
    public function getContent(): string
    {
        return $this->_content;
    }
    public function getDate(): DateTimeImmutable
    {
        return $this->_date;
    }
    public function getAuthor(): string
    {
        return $this->_author;
    }
    public function getImg(): string
    {
        return $this->_img;
    }
}
