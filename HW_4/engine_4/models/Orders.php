<?php
/* Класс для работы с заказами (Формирует структуру вокруг таблицы БД = orders) */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса Orders */

namespace app\models;

/* Формируем структуру класса Orders
 * Наследован от DbModel */

class Orders extends DbModel
{
    public $name; /* Имя заказчика */
    public $phone; /* Телефон заказчика */
    public $address; /* Адрес заказчика */
    public $session_id; /* ID сессии */

    /* Конструктор класса Orders */
    public function __construct($name = null, $phone = null, $address = null, $session_id = null)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->session_id = $session_id;
    }

    /* Метод возвращает имя таблицы в БД (<-- GeneralModel) */
    public static function getTableName()
    {
        return "orders";
    }
}