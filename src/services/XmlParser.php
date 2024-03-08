<?php

namespace src\Services;

use Exception;
use JetBrains\PhpStorm\Pure;
use SimpleXMLElement;
use src\Interfaces\ParserInterface;

class XmlParser implements ParserInterface
{
    public SimpleXMLElement $data;

    /**
     * Read the given file.
     *
     * @throws Exception
     */
    public function read($file): void
    {

        if (!file_exists($file)) {
            throw new Exception('File does not exist!');
        }

        $this->data = simplexml_load_file($file);
    }

    /**
     * Convert the object to an associative array.
     *
     * @param SimpleXMLElement $data
     * @return array
     */
    public function parseItem($data): array
    {
        return [
            'id' => $this->parseInteger($data->entity_id),
            'category' => $this->parseString($data->CategoryName),
            'sku' => $this->parseString($data->sku),
            'name' => $this->parseString($data->name),
            'description' => $this->parseString($data->description),
            'shortdesc' => $this->parseString($data->shortdesc),
            'price' => $this->parseFloat($data->price),
            'link' => $this->parseString($data->link),
            'image' => $this->parseString($data->image),
            'brand' => $this->parseString($data->Brand),
            'rating' => $this->parseInteger($data->Rating),
            'caffeine_type' => $this->parseString($data->CaffeineType),
            'count' => $this->parseInteger($data->Count),
            'flavored' => $this->parseYesNo($data->Flavored),
            'seasonal' => $this->parseYesNo($data->Seasonal),
            'instock' => $this->parseYesNo($data->Instock),
            'facebook' => $this->parseBoolean($data->Facebook),
            'iskcup' => $this->parseBoolean($data->IsKCup)
        ];
    }

    /**
     * @param $value
     * @return int
     */
    private function parseInteger($value): int
    {
        return (int)$value;
    }

    /**
     * @param $value
     * @return float
     */
    private function parseFloat($value): float
    {
        return (float)$value;
    }

    /**
     * @param $value
     * @return string
     */
    private function parseString($value): string
    {
        return trim((string)$value);
    }

    /**
     * @param $value
     * @return bool
     */
    #[Pure] private function parseBoolean($value): bool
    {
        return (bool)intval($value);
    }

    /**
     * @param $value
     * @return bool
     */
    private function parseYesNo($value): bool
    {
        return (strtolower($value) == 'yes');
    }

    /**
     * @return SimpleXMLElement
     */
    public function getData(): SimpleXMLElement
    {
        return $this->data;
    }

    /**
     * @param SimpleXMLElement $data
     */
    public function setData(SimpleXMLElement $data): void
    {
        $this->data = $data;
    }


}