<?php

namespace Controllers;

use Models\User;

class UserController
{
    /**
     * Форма авторизации
     */
    public function authorizationFormAction()
    {
        include 'views/user/authorization.php';
    }

    /**
     * Авторизация
     */
    public function authorizationAction()
    {
        $data = $_POST;

        if(
            empty($data['login'])
            AND
            empty($data['password'])
        ) {
            die('<div class="bg-danger">Ошибка заполните поля.</div>');
        }

        $user = new User();
        $result = $user->authorization($data['login'],$data['password']);

        if( empty($result) ) {
            die('<div class="bg-danger">Ошибка неправильный логин или пароль</div>');
        }

        $_SESSION['auth'] = true;
        print '<div class="bg-success">Успешно</div>';
    }

    /**
     * Выход
     */
    public function outAction()
    {
        session_destroy();
        header('Location: http://beejee/');
    }
}