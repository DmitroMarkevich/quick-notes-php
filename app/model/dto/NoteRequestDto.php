<?php

namespace app\model\dto;

class NoteRequestDto
{
    private string $title;
    private string $content;
    private string $accessType;

    /**
     * @param string $title
     * @param string $content
     * @param string $accessType
     */
    public function __construct(string $title, string $content, string $accessType)
    {
        $this->title = $title;
        $this->content = $content;
        $this->accessType = $accessType;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAccessType(): string
    {
        return $this->accessType;
    }

    public function setAccessType(string $accessType): void
    {
        $this->accessType = $accessType;
    }
}