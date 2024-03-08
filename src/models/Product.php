<?php

namespace src\Models;

use http\Exception\InvalidArgumentException;
use src\Databases\DB;
use src\Databases\MariaDB;
use src\Enums\CaffeineType;

class Product
{

    private string $table;
    private DB $db;

    private ?int $id = null;
    private ?string $category = null;
    private ?string $sku = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?string $shortdesc = null;
    private float $price = 0.00;
    private ?string $link = null;
    private ?string $image = null;
    private ?string $brand = null;
    private ?float $rating = null;
    private CaffeineType $caffeine_type = CaffeineType::NONE;
    private int $count = 0;
    private int $flavored = 0;
    private int $seasonal = 0;
    private int $instock = 0;
    private int $facebook = 0;
    private int $iskcup = 0;

    private array $fields = [
        'id', 'category', 'sku', 'name', 'description', 'shortdesc',
        'price', 'link', 'image', 'brand', 'rating', 'caffeine_type',
        'count', 'flavored', 'seasonal', 'instock', 'facebook', 'iskcup'
    ];

    public function __construct($params = [])
    {
        $this->table = 'products';

        $this->db = new DB(new MariaDB($this->table, $params));
    }

    public function createFromArray(array $data): void
    {
        foreach ($data as $k => $v) {
            $this->set($k, $v);
        }
    }

    public function save(): bool
    {
        return $this->db->write($this);
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function get(string $field)
    {
        if ($this->$field instanceof CaffeineType) {
            return $this->$field->value;
        }
        return $this->$field;
    }

    public function set(string $field, mixed $value): bool
    {
        if ($this->$field instanceof CaffeineType) {
            $this->setCaffeineType($value);
            return true;
        }
        $this->$field = $value;
        return true;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getShortdesc(): string
    {
        return $this->shortdesc;
    }

    /**
     * @param string $shortdesc
     */
    public function setShortdesc(string $shortdesc): void
    {
        $this->shortdesc = $shortdesc;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return CaffeineType
     */
    public function getCaffeineType(): CaffeineType
    {
        return $this->caffeine_type;
    }

    /**
     * @param CaffeineType|string $caffeine_type
     */
    public function setCaffeineType(CaffeineType|string $caffeine_type): void
    {
        if (is_string($caffeine_type)) {
            $caffeine_enum = (function (string $value): CaffeineType {
                foreach (CaffeineType::cases() as $enum) {
                    if ($enum->value === $value) {
                        return $enum;
                    }
                }

                throw new InvalidArgumentException('Invalid caffeine value');
            })($caffeine_type);
            $this->caffeine_type = $caffeine_enum;
        } else {
            $this->caffeine_type = $caffeine_type;
        }
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return bool
     */
    public function isFlavored(): bool
    {
        return $this->flavored;
    }

    /**
     * @param bool $flavored
     */
    public function setFlavored(bool $flavored): void
    {
        $this->flavored = $flavored;
    }

    /**
     * @return bool
     */
    public function isSeasonal(): bool
    {
        return $this->seasonal;
    }

    /**
     * @param bool $seasonal
     */
    public function setSeasonal(bool $seasonal): void
    {
        $this->seasonal = $seasonal;
    }

    /**
     * @return bool
     */
    public function isInstock(): bool
    {
        return $this->instock;
    }

    /**
     * @param bool $instock
     */
    public function setInstock(bool $instock): void
    {
        $this->instock = $instock;
    }

    /**
     * @return bool
     */
    public function isFacebook(): bool
    {
        return $this->facebook;
    }

    /**
     * @param bool $facebook
     */
    public function setFacebook(bool $facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return bool
     */
    public function isIskcup(): bool
    {
        return $this->iskcup;
    }

    /**
     * @param bool $iskcup
     */
    public function setIskcup(bool $iskcup): void
    {
        $this->iskcup = $iskcup;
    }

}