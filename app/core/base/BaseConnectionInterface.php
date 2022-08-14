<?php

namespace app\core\base;

interface BaseConnectionInterface
{
    public function execute($sql, $params = []);

    public function getOne($sql, $params = []);

    public function getAll($sql, $params): array;
}
