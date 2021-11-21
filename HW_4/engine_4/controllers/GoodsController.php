<?php
/* Класс контроллера каталога */

/* app согласно стандарту PSR-0 (\<Vendor Name>\(<Namespace>\)*<Class Name>) */
/* Создаем пространство имен класса GoodsController */

namespace app\controllers;

/* Формируем структуру класса GoodsController */

use app\models\Goods;

class GoodsController
{
    private $action; /* Свойство для хранения экшена */
    private $defaultAction = 'index'; /* Свойство для хранения экшена по умолчанию */
    private $layout = 'main'; /* Свойство для хранения шаблона по умолчанию */
    private $useLayout = true; /* Флаг, использовать ли $layout */

    /* Метод запуска экшена */
    public function runAction($action = null)
    {
        $this->action = $action ?: $this->defaultAction; /* Если $action = null то используем экшен по умолчанию */
        $method = "action" . ucfirst($this->action); /* Формируем полное имя экшена */
        if (method_exists($this, $method)) { /* Если метод существует */
            $this->$method(); /* Вызываем метод */
        } else { /* В противном случае */
            echo "404 Action Not Found"; /* Сообщаем пользователю об ошибке */
        }
    }

    /* Метод формирования главной страницы */
    public function actionIndex()
    {
        echo $this->render('index'); /* Передаем в --> render() */
    }

    /* Метод формирования страницы каталога */
    public function actionCatalog()
    {
        /* Получаем запрашиваемые товары из БД (-->models/DbModel.php -> getAllItem()) */
        $goods = Goods::getAllItem();
        echo $this->render('catalog', ['goods' => $goods]); /* Передаем в --> render() */
    }

    /* Метод формирования карточки товара */
    public function actionCard()
    {
        $id = $_GET['id']; /* Считываем ID товара из URL */
        /* Получаем запрашиваемый товар из БД (-->models/DbModel.php -> getOneItem()) (ОБЪЕКТ)*/
        $goods_card = Goods::getOneItem($id);
        echo $this->render('card', ['goods_card' => $goods_card]); /* Передаем в --> render() */
    }

    /* Метод рендера собранной страницы */
    public function render($template, $params = [])
    {
        if ($this->useLayout) { /* Если строим страницу по принципу "Матрешки" */
            /* Возвращаем результат выполнения метода рендера любого шаблона */
            return $this->renderTemplate("layouts/{$this->layout}", [
                'menu' => $this->renderTemplate('menu'), /* --> templates/layouts/main.php */
                'content' => $this->renderTemplate($template, $params) /* --> templates/layouts/main.php */
            ]);
        } else { /* В противном случае */
            /* Возвращаем результат выполнения метода рендера любого шаблона */
            return $this->renderTemplate($template, $params = []);
        }
    }

    /* Метод рендера любого шаблона */
    public function renderTemplate($template, $params = [])
    {
        ob_start(); /* Запускаем буферизацию вывода */
        extract($params); /* Импортируем переменные из массива в текущую таблицу символов */
        $templatePath = TEMPLATES_DIR . $template . ".php"; /* Формируем путь к файлу шаблона */

        if (file_exists($templatePath)) { /* Если файл существует */
            include $templatePath; /* Подключаем файл */
        } else { /* В противном случае */
            echo "404 Template Not Found"; /* Сообщаем пользователю об ошибке */
        }

        return ob_get_clean(); /* Возвращаем и очищаем содержимое буфера */
    }
}