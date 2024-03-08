<?php

namespace src\Services;

use src\Interfaces\ParserInterface;

class Parser
{

    private ParserInterface $parser;

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function read(string $file)
    {
        return $this->parser->read($file);
    }

    public function parseItem(mixed $data): array
    {
        return $this->parser->parseItem($data);
    }

    public function getData()
    {
        return $this->parser->getData();
    }
}