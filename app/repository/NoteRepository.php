<?php

namespace app\repository;

use app\model\Note;
use core\base\Repository;
use core\db\DBQueryBuilder;

class NoteRepository
{
    use Repository;

    public function __construct(DBQueryBuilder $dbQueryBuilder)
    {
        $this->setDBQueryBuilder($dbQueryBuilder);
    }

    public function findByUserId(string $userId): array
    {
        [$modelClass, $tableName] = $this->getModelClassAndTableName();

        $results = $this->dbQueryBuilder->select()
            ->from($tableName)
            ->where('user_id', '=', $userId)
            ->all();

        return array_map(fn($result) => $this->mapToModel($modelClass, $result), $results);
    }

    public function findByUserIdWithPagination(string $userId, int $limit, int $offset): array
    {
        [$modelClass, $tableName] = $this->getModelClassAndTableName();

        $results = $this->dbQueryBuilder->select()
            ->from($tableName)
            ->where('user_id', '=', $userId)
            ->limit($limit, $offset)
            ->all();

        return array_map(fn($result) => $this->mapToModel($modelClass, $result), $results);
    }

    protected function getModelClass(): string
    {
        return Note::class;
    }
}