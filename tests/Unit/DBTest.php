<?php

namespace Unit;

use PDOException;
use PHPUnit\Framework\TestCase;
use src\Databases\DB;
use src\Databases\MariaDB;
use src\Interfaces\DbInterface;
use src\Models\Product;

final class DBTest extends TestCase
{
    private DB $db;

    protected function setUp(): void
    {
        parent::setUp();
        // Provide your own database configuration or adjust accordingly
        $mariadb = new MariaDB('products', [
            'host' => 'db',
            'dbname' => 'test_db',
            'user' => 'user',
            'password' => 'password',
        ]);
        $this->db = new DB($mariadb);
        $this->db->beginTransaction();
    }
    public function testConnection()
    {
        // Ensure that the connection is successfully established
        $this->assertInstanceOf(DbInterface::class, $this->db->getDb());
    }

    public function testWrite()
    {
        // Create a sample product for testing
        $product = new Product();
        $product->setId(1408);
        $product->setName('Test Product');
        $product->setPrice(19.99);

        $result = $this->db->write($product);

        $this->assertTrue($result);
    }

    public function testWriteBadId() {
        $product = new Product();
        $product->setId(-238190532823);
        $product->setName('Test Product');
        $product->setPrice(19.99);

        $this->expectException(PDOException::class);
        $this->db->write($product);
    }

    public function tearDown(): void
    {
        $this->db->rollback();

        parent::tearDown();
    }

}
