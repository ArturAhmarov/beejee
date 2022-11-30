<?php

namespace Lib;

use FastRoute\Dispatcher,
    FastRoute\RouteCollector;

class Routing
{
    /**
     * Роутинг FastRoute
     */
    public function route()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function(RouteCollector $r) {
            $r->addRoute('GET', '/', 'Controllers\TaskController::listAction');
            $r->addRoute('GET', '/add/', 'Controllers\TaskController::formAddAction');
            $r->addRoute('POST', '/add/', 'Controllers\TaskController::addAction');
            $r->addRoute('GET', '/update/{id}', 'Controllers\TaskController::updateFormAction');
            $r->addRoute('POST', '/update/', 'Controllers\TaskController::updateAction');
            $r->addRoute('GET', '/authorization/', 'Controllers\UserController::authorizationFormAction');
            $r->addRoute('POST', '/authorization/', 'Controllers\UserController::authorizationAction');
            $r->addRoute('GET', '/out/', 'Controllers\UserController::outAction');
            $r->addRoute('GET', '/{order}/{by}', 'Controllers\TaskController::listAction');
        });


        // Получаем метод запроса и сам URL
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Проверяем, есть ли GET параметры
        if ( false !== $pos = strpos($uri, '?') ) {
            $uri = substr($uri, 0, $pos);
        }

        // Декодируем URL
        $uri = rawurldecode($uri);
        // Берём информацию о роутинге
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        // Проверяем
        switch ($routeInfo[0]) {
            // Если нет страницы
            case Dispatcher::NOT_FOUND:
                die('NOT_FOUND');
            // Если нет метода для обработки
            case Dispatcher::METHOD_NOT_ALLOWED:
                die('Not Allowed');
            // Если всё нашлось
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                list($class, $method) = explode('::', $handler, 2);
                call_user_func_array([new $class, $method], $vars);
                break;
        }
    }
}