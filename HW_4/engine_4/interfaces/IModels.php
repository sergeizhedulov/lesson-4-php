<?php
/* Класс интерфейса */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса IModels */

namespace app\interfaces;

/* Формируем структуру класса IModels
 * Реализуется в GeneralModel */

interface IModels
{
    public static function getOneItem($id);
    public static function getAllItem();
    public static function getTableName();
}