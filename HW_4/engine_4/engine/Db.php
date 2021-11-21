<?php
/* Класс для работы с базой данных */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса Db */

namespace app\engine;

/* Используем пространство имен директории traits, для доступа к трейту TSingletone */

use app\traits\TSingletone;

/* Формируем структуру класса Db */

class Db
{
    use TSingletone; /* Подключаем трейт с дополнительным функционалом для класса Db */

    /* Массив с информацией о базе данных */
    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'powertoplay1',
        'charset' => 'utf8'
    ];
    private $connection = null; /* Свойство для хранения соединения с БД */

    /* Метод установки соединения с БД. Возвращает результат в виде ассоциативного массива */
    private function getConnection() /* (<-- $connection) */
    {
        if (is_null($this->connection)) { /* Если соединение с БД не было установлено */
            $this->connection = new \PDO($this->prepareDSNString(),
                $this->config['login'],
                $this->config['password']
            ); /* Устанавливаем соединение */
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            /* Настраиваем режим получения данных в виде ассоциативного массива */
        }
        return $this->connection; /* В противном случае возвращаем хранящееся соединение ($connection) */
    }

    /* Метод возвращает подготовленную строку с данными для метода --> getConnection */
    private function prepareDSNString()
    {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        ); /* %s - спецсимвол строки */
    }

    /* Метод возвращает ID последней выполненной операции с БД */
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /* Метод выполняет и возвращает результат любого SQL запроса в виде ассоциативного массива
     * $sql - "SELECT FROM `goods` WHERE `id` = :id <- это плейсхолдер <- (существует вариант с ?)", ["id" => 1]
     * $params - Массив дополнительных данных */
    private function query($sql, $params) /* (<-- метод queryAll) */
    {
        $pdoStatement = $this->getConnection()->prepare($sql); /* Подготавливаем запрос */
        $pdoStatement->execute($params); /* Выполняем запрос (Параметры будут забиндены автоматически) */
        return $pdoStatement;
    }

    /* Метод выполняет и возвращает результат любого SQL запроса в виде объекта
     * $sql - "SELECT FROM `goods` WHERE `id` = :id <- это плейсхолдер <- (существует вариант с ?)", ["id" => 1]
     * $params - Массив дополнительных данных */
    public function queryObject($sql, $params, $class)
    {
        $pdoStatement = $this->query($sql, $params); /* (--> query(...)) */
        $pdoStatement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        /* Настраиваем режим получения данных в виде объекта */
        return $pdoStatement->fetch();
    }

    /* Метод используется для выполнения операций которые не требуют возврата данных (Например: update и delete)
     * $sql - "SELECT FROM `goods` WHERE `id` = :id <- это плейсхолдер <- (существует вариант с ?)", ["id" => 1]
     * $params - Массив дополнительных данных */
    public function execute($sql, $params)
    {
        $this->query($sql, $params);
        return true;
    }

    /* Метод возвращает результат выполнения SQL запроса для одной записи в БД (<-- models/GeneralModel.php) */
    public function queryOne($sql, $params = [])
    {
        return $this->queryAll($sql, $params)[0]; /* (--> метод queryAll) */
    }

    /* Метод возвращает результат выполнения SQL запроса для всех записей в БД (<-- models/GeneralModel.php) */
    public function queryAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(); /* (--> метод query) */
    }

    public function __toString()
    {
        return "Db";
    }
}