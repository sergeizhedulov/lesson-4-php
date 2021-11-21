<?php
/* Класс для работы с новостями (Формирует структуру вокруг таблицы БД = news) */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса News */

namespace app\models;

/* Формируем структуру класса News
 * Наследован от DbModel */

class News extends DbModel
{
    public $title; /* Оглавление новости */
    public $preview; /* Короткое описание */
    public $full; /* Полное описание */

    /* Конструктор класса News */
    public function __construct($title = null, $preview = null, $full = null)
    {
        $this->title = $title;
        $this->preview = $preview;
        $this->full = $full;
    }

    /* Метод возвращает имя таблицы в БД (<-- GeneralModel) */
    public static function getTableName()
    {
        return "news";
    }
}