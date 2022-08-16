<?php

namespace app\core\base;

use app\core\Environment;
use Exception;
use PDO;
use PDOStatement;

class DbConnection implements BaseConnectionInterface
{
    private PDO $db;

    public function __construct($connectionString, $userName, $password)
    {
        $this->db = new PDO($connectionString, $userName, $password);
    }

    /**
     * @throws Exception
     */
    public function getPreparedQuery($sql, $params = []): PDOStatement
    {
        $preparedQuery = $this->db->prepare($sql);

        try {
            $preparedQuery->execute($params);
        } catch (Exception $exception) {
            if (Environment::getParam(Environment::KEY_DEBUG)) {
                $this->showDebugInfoForPreparedQuery($preparedQuery, $exception);
            }

            throw $exception;
        }

        return $preparedQuery;
    }

    /**
     * @throws Exception
     */
    public function execute($sql, $params = []): PDOStatement
    {
        return $this->getPreparedQuery($sql, $params);
    }

    /**
     * @throws Exception
     */
    public function getOne($sql, $params = [])
    {
        return $this->getPreparedQuery($sql, $params)->fetch();
    }

    /**
     * @throws Exception
     */
    public function getAll($sql, $params = []): array
    {
        return $this->getPreparedQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** @noinspection ForgottenDebugOutputInspection */
    public function showDebugInfoForPreparedQuery(PDOStatement $preparedQuery, Exception $exception): void
    {
        print "<p>$preparedQuery->queryString</p>";
        $preparedQuery->debugDumpParams();
        print_r($exception->getMessage());
        exit;
    }
}
