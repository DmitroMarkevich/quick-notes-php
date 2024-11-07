<?php

namespace app\model;

use core\base\Model;
use DateTime;

class Note extends Model
{
    private const TABLE_NAME = 'notes';

    private string $title;
    private string $content;
    private string $accessType;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private ?string $userId;

    public function __construct(
        string $title,
        string $content,
        string $accessType,
        ?string $userId
    ) {
        parent::__construct();

        $this->title = $title;
        $this->content = $content;
        $this->accessType = $accessType;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->userId = $userId;
    }

    /**
     * Returns the name of the table in the database.
     *
     * @return string The name of the table associated with this model.
     */
    public static function getTableName(): string
    {
        return self::TABLE_NAME;
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

    public function setAccessType(bool $accessType): void
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

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }
}