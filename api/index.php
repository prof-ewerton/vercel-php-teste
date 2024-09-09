<?php
/*
* Project Cody
* Autor: Ewerton Mendonça
* Descrição:
*/
require_once('modules/Addons.class.php');
require_once('modules/Router.class.php');

class Cody {

    public static function main() {
        session_name(md5('seg' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
        session_cache_expire(5);
        session_start();

        if (!isset($_SESSION['TOKEN'])) {
            $_SESSION['TOKEN'] = md5(time());
        }

        $router = new Router();
        $addons = new Addons($router);

        $router->execute();
    }
}

Cody::main();
