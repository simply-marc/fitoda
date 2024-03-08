<?php

namespace src\Databases;

use PDO;
use PDOException;
use src\Interfaces\DbInterface;
use src\Models\Product;

class MariaDB implements DbInterface
{
    private PDO $con;
    private string $table;

    private string $host;
    private string $dbname;
    private string $user;
    private string $password;

    /**
     * @param $table
     * @param array $params
     */
    public function __construct($table, array $params = [])
    {
        $this->table = $table;

        $config = parse_ini_file("config.ini", true)['Database'];

        $this->host = $params['host'] ?? $config['host'] ?? null;
        $this->dbname = $params['dbname'] ?? $config['dbname'] ?? null;
        $this->user = $params['user'] ?? $config['user'] ?? null;
        $this->password = $params['password'] ?? $config['password'] ?? null;
    }

    /**
     * Try to establish a connection to the database.
     *
     * @return void
     */
    public function connect(): void
    {
        try {
            $this->con = new PDO($this->getDsn(), $this->getUser(), $this->getPassword());
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Prepare and execute the query.
     *
     * @param $query
     * @param array $query_params
     * @return bool
     */
    public function execute($query, array $query_params = []): bool
    {
        $sth = $this->con->prepare($query);
        return $sth->execute($query_params);
    }

    /**
     * Fetch the result.
     *
     * @param $result
     * @return mixed
     */
    public function fetch($result): mixed
    {
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new product into the table.
     *
     * @param Product $data
     * @return bool
     */
    public function write(Product $data): bool
    {
        $fields = $data->getFields();
        $data_array = [];

        foreach ($fields as $field) {
            $value = $data->get($field);

            if ($value !== null) {
                $data_array[$field] = is_bool($value) ? (int)$value : $value;
            }
        }

        $data_field_keys = array_keys($data_array);
        $columns = implode(', ', $data_field_keys);
        $values = ':' . implode(', :', $data_field_keys);
        return $this->execute("INSERT INTO $this->table ($columns) VALUES ($values)", $data_array);
    }

    /**
     * Begin a transaction so that changes can be rolled back.
     *
     * @return void
     */
    public function beginTransaction(): void
    {
        $this->con->beginTransaction();
    }

    /**
     * Rollback a transaction.
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->con->rollBack();
    }

    /**
     * Create the data source name string.
     *
     * @return string
     */
    public function getDsn(): string
    {
        return 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    }

    /**
     * @return mixed
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getDbname(): string
    {
        return $this->dbname;
    }

    /**
     * @param string $dbname
     */
    public function setDbname(string $dbname): void
    {
        $this->dbname = $dbname;
    }

    /**
     * @return mixed
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}