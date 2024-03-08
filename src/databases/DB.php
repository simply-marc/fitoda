<?php

namespace src\Databases;

use src\Interfaces\DbInterface;

class DB
{

    private DbInterface $db;

    public function __construct(DbInterface $db)
    {
        $this->db = $db;
        $this->db->connect();
    }

    public function fetch($result): void
    {
        $this->getDb()->fetch($result);
    }

    public function write($data): bool
    {
        return $this->getDb()->write($data);
    }

    public function beginTransaction(): void
    {
        $this->getDb()->beginTransaction();
    }

    public function rollback(): void
    {
        $this->getDb()->rollBack();
    }

    /**
     * @return DbInterface
     */
    public function getDb(): DbInterface
    {
        return $this->db;
    }

    /**
     * @param DbInterface $db
     */
    public function setDb(DbInterface $db): void
    {
        $this->db = $db;
    }

}