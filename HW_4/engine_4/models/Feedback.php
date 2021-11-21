<?php
/* Класс для работы с отзывами (Формирует структуру вокруг таблицы БД = feedback) */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса Feedback */

namespace app\models;

/* Формируем структуру класса Feedback
 * Наследован от DbModel */

class Feedback extends DbModel
{
    public $name; /* Имя пользователя */
    public $feedback; /* Отзыв */

    /* Конструктор класса Feedback */
    public function __construct($name = null, $feedback = null)
    {
        $this->name = $name;
        $this->feedback = $feedback;
    }

    /* Метод возвращает имя таблицы в БД (<-- GeneralModel) */
    public static function getTableName()
    {
        return "feedback";
    }
}