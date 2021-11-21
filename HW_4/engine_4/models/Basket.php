<?php
/* Класс для работы с корзиной (Формирует структуру вокруг таблицы БД = basket) */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса Basket */

namespace app\models;

/* Формируем структуру класса Basket
 * Наследован от DbModel */

class Basket extends DbModel
{
    public $session_id; /* ID сессии */
    public $goods_id; /* ID товара */

    /* Конструктор класса Basket */
    public function __construct($session_id = null, $goods_id = null)
    {
        $this->session_id = $session_id;
        $this->goods_id = $goods_id;
    }

    /* Метод возвращает имя таблицы в БД (<-- GeneralModel) */
    public static function getTableName()
    {
        return "basket";
    }
}