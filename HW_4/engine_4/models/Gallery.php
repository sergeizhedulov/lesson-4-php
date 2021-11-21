<?php
/* Класс для работы с галереей (Формирует структуру вокруг таблицы БД = gallery) */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса Gallery */

namespace app\models;

/* Формируем структуру класса Gallery
 * Наследован от DbModel */

class Gallery extends DbModel
{
    public $filename; /* Имя файла */
    public $likes; /* Количество лайков */

    /* Конструктор класса Gallery */
    public function __construct($filename = null, $likes = null)
    {
        $this->filename = $filename;
        $this->likes = $likes;
    }

    /* Метод возвращает имя таблицы в БД (<-- GeneralModel) */
    public static function getTableName()
    {
        return "gallery";
    }
}