<?php
/*
* Project Cody
* Autor: Ewerton Mendonça
* Descrição: Addon que cria uma página inicial (padrão do sistema) e a página de erro 404.
*/
require_once("addons/Addon.class.php");

class StaticPages extends Addon {
    
    public function __construct($router) {
        $router->addRoute('/', array($this, "index"));
        $router->addRoute('/about', array($this, "error"));
    }

    public function index() {
        echo <<<EOL
        <html lang="pt-br">
        <body>
        <h1>Cody ;D</h1>
        <p>Cody ;D é um ambiente de auxilio educacional.</p>
        </body>
        EOL;
    }

    public function error() {
        echo <<<EOL
        <html lang="pt-br">
        <body>
        <h1>Cody :'(</h1>
        <p>Ocorreu um erro no sistema.</p>
        <p>Entre em contato com o administrador.</p>
        </body>
        EOL;
    }
}