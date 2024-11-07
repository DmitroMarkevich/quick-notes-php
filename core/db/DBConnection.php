<?php

namespace core\db;

use core\Configurator;
use PDO;
use PDOException;
use RuntimeException;

class DBConnection
{
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private ?PDO $connection = null;

    public function __construct()
    {
        $databaseConfig = new Configurator('config');
        $databaseConfig = $databaseConfig->get('database');

        $this->host = $databaseConfig['host'];
        $this->dbName = $databaseConfig['dbname'];
        $this->username = $databaseConfig['username'];
        $this->password = $databaseConfig['password'];
    }

    /**
     * Establishes a PDO connection to the database.
     *
     * @return PDO|null PDO connection object or null if connection fails.
     * @throws RuntimeException If the connection to the database fails.
     */
    public function connect(): ?PDO
    {
        if ($this->connection) {
            return $this->connection;
        }

        try {
            $dsn = $this->createDsn();
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed.');
        }
    }

    /**
     * Creates a DSN (Data Source Name) string for the PDO connection.
     *
     * @return string DSN string for the PDO connection.
     */
    private function createDsn(): string
    {
        return "mysql:host=$this->host;dbname=$this->dbName;charset=utf8";
    }

    /**
     * Disconnects the PDO connection.
     */
    public function disconnect(): void
    {
        $this->connection = null;
    }

    /**
     * Returns the current PDO connection instance.
     *
     * @return PDO|null The current PDO connection or null if not connected.
     */
    public function getConnection(): ?PDO
    {
        return $this->connection;
    }

    /**
     * Destructor.
     * Ensures the PDO connection is closed when the object is destroyed.
     */
    public function __destruct()
    {
        $this->disconnect();
    }
}