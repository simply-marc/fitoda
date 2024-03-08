<?php

namespace src\Interfaces;

interface ParserInterface
{
    public function read(string $file);

    public function parseItem($data);

    public function getData();
}