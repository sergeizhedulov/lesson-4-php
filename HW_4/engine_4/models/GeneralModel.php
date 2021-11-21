<?php
/* Класс для сбора общих Свойств/Методов для всех моделей */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса GeneralModel */

namespace app\models;

/* Используем пространства имен директорий engine, interfaces для получения доступа к необходимым классам */

use app\interfaces\IModels;

/* Формируем структуру класса GeneralModel
 * Создание экземпляров класса ЗАПРЕЩЕНО (abstract)
 * Реализуем интерфейс interfaces/IModels.php */

abstract class GeneralModel implements IModels
{
}