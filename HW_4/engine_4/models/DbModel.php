<?php
/* Класс для работы с БД */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса DbModel */

namespace app\models;

/* Формируем структуру класса DbModel */

/* Используем пространства имен директорий models, для получения доступа к необходимым классам */

use app\engine\Db;

abstract class DbModel extends GeneralModel
{
    /* Обязуем реализовать метод возвращающий имя таблицы в БД в наследниках (abstract) */
    abstract public static function getTableName();

    /* Метод запрашивает результат выполнения SQL запроса у экземпляра класса Db для одной записи в БД
     * $id - ID позиции для формирования SQL запроса */
    public static function getOneItem($id)
    {
        $tableName = static::getTableName(); /* Получаем имя таблицы БД (<-- наследниками) */
        $sql = "SELECT * FROM `{$tableName}` WHERE `id` = :id"; /* Формируем SQL запрос на получение записи из БД по ID,
        где :id <- это плейсхолдер */
        return Db::getInstance()->queryObject($sql, ['id' => $id], static::class); /* (--> engine/Db.php) */
    }

    /* Метод запрашивает результат выполнения SQL запроса у экземпляра класса Db для всех записей в БД */
    public static function getAllItem()
    {
        $tableName = static::getTableName(); /* Получаем имя таблицы БД (<-- наследниками) */
        $sql = "SELECT * FROM `{$tableName}`"; /* Формируем запрос на получение всех записей в БД */
        return Db::getInstance()->queryAll($sql); /* (--> engine/Db.php) */
    }

    /* ... */
    public function getLimit($from, $to)
    {
    }

    /* ... */
    public function getWhere($name, $value)
    {
    }

    /* Метод синхронизации экземпляра объекта с БД */
    public function save()
    {
        if (is_null($this->id)) { /* Если свойство id экземпляра объекта пустое */
            $this->insert(); /* Вызываем метод добавления экземпляра объекта в БД */
        } else {
            $this->update(); /* Вызываем метод обновления экземпляра объекта в БД */
        }
    }

    /* Метод добавления данных в таблицу БД */
    public function insert()
    {
        $params = []; /* Массив дополнительных данных для метода (--> engine/Db.php -> query(...)),
        * где ключ - плейсхолдер, значение - значение */
        $columns = []; /* Массив полей БД для подставления в SQL запрос */
        $tableName = static::getTableName(); /* Получаем имя таблицы БД (<-- наследниками) */

        foreach ($this as $key => $value) { /* Перебираем свойства экземпляра класса */
            if ($key == "id") { /* Если существует свойство с именем id */
                continue; /* Переходим к следующей итерации */
            }
            $params[":{$key}"] = $value; /* Формиируем плейсхолдеры */
            $columns[] = "`$key`"; /* Формируем поля в соответствии с таблицей БД */
        }

        $columns = implode(', ', $columns); /* Преобразуем в строку поля для таблицы БД */
        $values = implode(', ', array_keys($params)); /* Преобразуем в строку значения для таблицы БД */
        $sql = "INSERT INTO `{$tableName}` ({$columns}) VALUES ({$values})"; /* Формируем SQL запрос на добавление
        * записей в таблицу БД */
        Db::getInstance()->execute($sql, $params); /* Выполняем запрос (--> engine/Db.php -> query(...)) */
        $this->id = Db::getInstance()->lastInsertId(); /* Присваиваем свойству ID значение в соответствии с БД */

        return $this; /* Возвращаем ссылку на экземпляр класса (Возвращается объект) */
    }

    /* Метод удаления данных из таблицы БД */
    public function delete()
    {
        $tableName = static::getTableName(); // Получаем имя таблицы БД (<-- наследниками)
        $sql = "DELETE FROM `{$tableName}` WHERE `id` = :id"; /* Формируем SQL запрос на удаление записей из таблицы БД */
        return Db::getInstance()->execute($sql, ["id" => $this->id]); /* Выполняем запрос (--> engine/Db.php -> execute(...)) */
        /* return $this;
         * Можно так же вернуть ссылку на экземпляр класса (Возвращается объект)
         * Для вызова методов класса подряд */
    }

    /* Метод обновления данных в таблице БД (По аналогии с методом insert) */
    public function update()
    {
    }
}