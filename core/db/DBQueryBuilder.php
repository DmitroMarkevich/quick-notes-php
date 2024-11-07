<?php

namespace core\db;

use PDO;
use InvalidArgumentException;

class DBQueryBuilder
{
    private array $queryParts = [
        "select" => [],
        "where" => [],
        "having" => [],
        "order" => [],
        "join" => [],
        "fields" => [],
        "table" => null,
        "group" => null,
        "limit" => null
    ];

    private DBConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
        $this->dbConnection->connect();
    }

    private static function _field(string $f): string
    {
        return "`" . str_replace("`", "``", $f) . "`";
    }

    public function insert(array $data): bool
    {
        $fields = array_map([self::class, '_field'], array_keys($data));
        $placeholders = array_map(function ($key) {
            return ":$key";
        }, array_keys($data));

        $query = "INSERT INTO " . $this->queryParts["table"];
        $query .= " (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";

        $statement = $this->dbConnection->getConnection()->prepare($query);

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $result = $statement->execute();
        $this->resetQueryParts();
        return $result;
    }

    public function select($fields = "*"): self
    {
        if ($fields === "*") {
            $this->queryParts["fields"] = ["*"];
        } else {
            $this->queryParts["fields"] = array_map(function ($field) {
                return self::_field($field);
            }, (array)$fields);
        }

        return $this;
    }

    public function from(string $table): self
    {
        $this->queryParts["table"] = self::_field($table);

        return $this;
    }

    public function where(
        string $fieldName,
        string $operator,
        $value = null,
        bool $isRawField = false,
        string $conditionType = ""
    ): self {
        $this->_where($fieldName, $operator, $value, $isRawField, $conditionType);
        return $this;
    }

    private function _where(string $fieldName, string $operator, $value, bool $isRawField, string $conditionType): void
    {
        if ($value === null) {
            $value = $operator;
            $operator = "=";
        }

        $validOperators = ['=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IN', 'NOT IN', 'BETWEEN', 'IS', 'IS NOT'];
        if (!in_array(strtoupper($operator), $validOperators, true)) {
            throw new InvalidArgumentException("Invalid operator '$operator' provided.");
        }

        if (!$isRawField) {
            $fieldName = self::_field($fieldName);
        }

        if (!$isRawField && is_scalar($value) && !in_array($value[0], ['?', ':'], true)) {
            $value = $this->dbConnection->getConnection()->quote($value);
        }

        $this->queryParts["where"][] = [$conditionType, $fieldName, $operator, $value];
    }

    public function orderBy(string $fieldName, string $direction = 'ASC'): self
    {
        $validDirections = ['ASC', 'DESC'];
        $direction = strtoupper($direction);

        if (!in_array($direction, $validDirections)) {
            throw new InvalidArgumentException("Invalid sorting direction '$direction'.");
        }

        $this->queryParts['order'][] = self::_field($fieldName) . " $direction";
        return $this;
    }

    public function limit(int $limit, int $offset = 0): self
    {
        if ($limit < 0) {
            $limit = 0;
        }

        if ($offset < 0) {
            $offset = 0;
        }

        $this->queryParts['limit'] = "LIMIT $offset, $limit";
        return $this;
    }

    public function groupBy(string $field): self
    {
        $this->queryParts['group'] = self::_field($field);
        return $this;
    }

    private function buildWhereClause(): string
    {
        $whereClause = '';
        if (!empty($this->queryParts["where"])) {
            $whereClause .= " WHERE";
            foreach ($this->queryParts["where"] as $w) {
                $whereClause .= " $w[0] ";
                if (count($w) > 1) {
                    $whereClause .= " $w[1] $w[2] $w[3]";
                }
            }
        }
        return $whereClause;
    }

    public function buildSelect(): string
    {
        if (empty($this->queryParts["table"])) {
            throw new InvalidArgumentException("Table name must be set before building the SELECT query.");
        }

        $fields = empty($this->queryParts["fields"]) ? "*" : implode(", ", $this->queryParts["fields"]);
        $query = "SELECT $fields FROM {$this->queryParts["table"]}";
        $query .= $this->buildWhereClause();

        if (!empty($this->queryParts['group'])) {
            $query .= " GROUP BY " . $this->queryParts['group'];
        }

        if (!empty($this->queryParts["order"])) {
            $query .= " ORDER BY " . implode(", ", $this->queryParts["order"]);
        }

        if (!empty($this->queryParts['limit'])) {
            $query .= " " . $this->queryParts['limit'];
        }

        return $query;
    }

    public function one(array $data = []): ?array
    {
        $query = $this->buildSelect();
        $statement = $this->dbConnection->getConnection()->prepare($query);
        $statement->execute($data);
        $this->resetQueryParts();
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function all($data = []): ?array
    {
        $query = $this->buildSelect();
        $statement = $this->dbConnection->getConnection()->prepare($query);
        $statement->execute($data);
        $this->resetQueryParts();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setTableName(string $tableName): void
    {
        $this->queryParts['table'] = self::_field($tableName);
    }

    public function resetQueryParts(): void
    {
        $this->queryParts = [
            "select" => [],
            "where" => [],
            "having" => [],
            "order" => [],
            "join" => [],
            "fields" => [],
            "table" => null,
            "group" => null,
            "limit" => null
        ];
    }
}