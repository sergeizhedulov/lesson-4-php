<?php
/* Класс для работы с пользователями (Формирует структуру вокруг таблицы БД = users) */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем ространство имен класса Users */

namespace app\models;

/* Формируем структуру класса Users
 * Наследован от DbModel */

class Users extends DbModel
{
    public $login; /* Логин пользователя */
    public $password; /* Пароль пользователя */
    public $hash; /* Хеш пользователя */

    /* Конструктор класса Users */
    public function __construct($login = null, $password = null, $hash = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->hash = $hash;
    }

    /* Метод возвращает имя таблицы в БД (<-- GeneralModel) */
    public static function getTableName()
    {
        return "users";
    }
}