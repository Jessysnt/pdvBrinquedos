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

/**
 * Adicionar as rotas
 */ 

//Rotas iniciais
$router->add('', ['controller' => 'LoginController', 'action' => 'logar']);
$router->add('login', ['controller' => 'LoginController', 'action' => 'logar']);
$router->add('registro', ['controller' => 'RegistrarController', 'action' => 'primeiroRegistro']);
$router->add('painel', ['controller' => 'PainelController', 'action' => 'painel']);
$router->add('sair', ['controller' => 'LoginController', 'action' => 'sair']);

//Rotas de Usuario
$router->add('usuarioF', ['controller' => 'UsuarioController', 'action' => 'usuarioForm']);
$router->add('tabUsuario', ['controller' => 'UsuarioController', 'action' => 'tababelaUsuario']);
$router->add('obtUsuario', ['controller' => 'UsuarioController', 'action' => 'obterUsuario']);
$router->add('apagarUsuario', ['controller' => 'UsuarioController', 'action' => 'apagarUsuario']);
$router->add('atualizaUsuario', ['controller' => 'UsuarioController', 'action' => 'atualizaUsuario']);

//Rotas dos Produtos
$router->add('produtoF', ['controller' => 'ProdutoController', 'action' => 'produtoForm']);

//Rotas Produtos Preço
$router->add('produtoVAdd', ['controller' => 'ProdutoVendaController', 'action' => 'produtoAdd']);
$router->add('mostrar', ['controller' => 'ProdutoVendaController', 'action' => 'mostrarProdutos']);

//Rotas Estoque
$router->add('estoque', ['controller' => 'ProdutoController', 'action' => '']);

// $router->add('nova', ['controller' => 'Home', 'action' => 'nova']);
// $router->add('{controller}/{action}');


//Rotas fora da sessao
session_start();
if(isset($_SESSION['usuario']) || in_array($_SERVER['REQUEST_URI'],['/login', '/sair', '/registro'])) {
    $router->dispatch($_SERVER['REQUEST_URI']);
}else{
    $router->dispatch('/login');
}

// $router->dispatch($_SERVER['QUERY_STRING']);