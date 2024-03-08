<?php

namespace src\Interfaces;

interface DbInterface
{
    public function connect();

    public function execute($query, array $query_params);

    public function fetch($result);
}