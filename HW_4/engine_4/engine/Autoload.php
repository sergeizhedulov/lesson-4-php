<?php
/* Класс автозагрузки моделей приложения */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Пространство имен класса Autoload */

namespace app\engine;

/* Формируем структуру класса Autoload */

class Autoload
{
    /* Метод загрузки моделей приложения (<-- public/index.php)
     * $className - Имя модели для подключения (<-- public/index.php) */
    public function loadClass($className)
    {
        /* Формирование абсолютного пути к файлу для 1го и 2го способа (См. config)
         * $fileName = str_replace(['app\\', '\\'], [ROOT_DIR, DS], $className) . ".php"; // Для 1го способа
         * $fileName = str_replace(['app', '\\'], [ROOT_DIR, DS], $className) . ".php"; // Для 2го способа */

        /* Формирование абсолютного пути к файлу при помощи realpath */
        $fileName = realpath(str_replace(['app', '\\'], [ROOT_DIR, DS], $className) . ".php");
        if (file_exists($fileName)) { /* Если файл найден */
            include $fileName; /* Подключаем файл */
        }
    }
}