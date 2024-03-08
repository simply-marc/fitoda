<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use src\Models\Product;

final class ProductTest extends TestCase {

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function testCreateFromArray()
    {
        $data = [
            'id' => 99999999999,
            'name' => 'Test Product',
            'price' => 19.99,
            'category' => 'Test Category',
        ];

        $this->product->createFromArray($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $this->product->get($key));
        }
    }

}