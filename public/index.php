<?php

/**
 * Controller inicial front
 * 
 */
// Carregar autoload (uso do gerenciador de pacotes composer)
require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Tratamento de erros e exceções
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Controlador de rotas
 */
$router = new Core\Router();

// Adicionar as rotas
$router->add('', ['controller' => 'LoginController', 'action' => 'logar']);
$router->add('login', ['controller' => 'LoginController', 'action' => 'logar']);
$router->add('registro', ['controller' => 'RegistrarController', 'action' => 'primeiroRegistro']);
$router->add('painel', ['controller' => 'PainelController', 'action' => 'painel']);
$router->add('sair', ['controller' => 'LoginController', 'action' => 'sair']);
$router->add('', ['controller' => 'LoginController', 'action' => 'sair']);
// $router->add('nova', ['controller' => 'Home', 'action' => 'nova']);
// $router->add('{controller}/{action}');

session_start();
if(isset($_SESSION['usuario']) || in_array($_SERVER['REQUEST_URI'],['/login', '/sair', '/registro'])) {
    $router->dispatch($_SERVER['REQUEST_URI']);
}else{
    $router->dispatch('/login');
}

// $router->dispatch($_SERVER['QUERY_STRING']);