<?php

namespace app\model\dto;

use DateTime;

class NoteResponseDto
{
    private string $title;
    private string $content;
    private string $accessType;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    /**
     * @param string $title
     * @param string $content
     * @param string $accessType
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct(
        string $title,
        string $content,
        string $accessType,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->accessType = $accessType;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}