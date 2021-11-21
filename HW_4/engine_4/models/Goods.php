<?php
/* Класс для работы с товарами (Формирует структуру вокруг таблицы БД = goods) */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса Goods */

namespace app\models;

/* Формируем структуру класса Goods
 * Наследован от DbModel */

class Goods extends DbModel
{
    public $id; /* ID товара */
    public $image; /* Изображение товара */
    public $name; /* Наименование товара */
    public $price; /* Стоимость товара */
    public $description; /* Описание товара */

    /* Свойство для доработки метода models/GeneralModel.php --> insert()
     * Перечислены имена необходимых для формирования SQL запроса полей
     * Избавляет от лишних проверок
     * НЕ РЕАЛИЗОВАНО!!! */
    private $props = [
        'image', 'name', 'price', 'description'
    ];

    /* Конструктор класса Goods */
    public function __construct($image = null, $name = null, $price = null, $description = null)
    {
        $this->image = $image;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    /* Метод возвращает имя таблицы в БД (<-- GeneralModel) */
    public static function getTableName()
    {
        return "goods";
    }
}