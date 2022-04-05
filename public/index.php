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
$router->add('usuario-add', ['controller' => 'UsuarioController', 'action' => 'usuarioAdd']);
$router->add('tab-usuario', ['controller' => 'UsuarioController', 'action' => 'tabelaUsuario']);
$router->add('obt-usuario', ['controller' => 'UsuarioController', 'action' => 'obterUsuario']);
$router->add('apg-usuario', ['controller' => 'UsuarioController', 'action' => 'apagarUsuario']);
$router->add('atz-usuario', ['controller' => 'UsuarioController', 'action' => 'atualizaUsuario']);

//Rotas de Cliente
$router->add('cliente-add', ['controller' => 'ClienteController', 'action' => 'clienteAdd']);


//Rotas dos Produtos
$router->add('produto-form', ['controller' => 'ProdutoController', 'action' => 'produtoForm']);

//Rotas Produtos Preço
$router->add('produto-venda', ['controller' => 'ProdutoVendaController', 'action' => 'produtoVenda']);
$router->add('prod-vend-add', ['controller' => 'ProdutoVendaController', 'action' => 'produtoAdd']);
$router->add('tab-prod-vend', ['controller' => 'ProdutoVendaController', 'action' => 'tabelaProdutoVenda']);
$router->add('obt-produtov', ['controller' => 'ProdutoVendaController', 'action' => 'obterProdutoV']);
$router->add('atz-prod-venda', ['controller' => 'ProdutoVendaController', 'action' => 'atualizarProdutoVenda']);
$router->add('apg-prod-ven', ['controller' => 'ProdutoVendaController', 'action' => 'apagarProdutoVenda']);

//Rotas Estoque
$router->add('estoque', ['controller' => 'EstoqueController', 'action' => 'estoque']);

//Rotas de Comandas
$router->add('comandas', ['controller' => 'ComandaController', 'action' => 'telaInicial']);
$router->add('pesquisar-produto', ['controller' => 'ComandaController', 'action' => 'pesquisarProd']);
$router->add('pesquisar-cliente', ['controller' => 'ComandaController', 'action' => 'pesquisarCli']);
$router->add('pesquisar-prod-est', ['controller' => 'ComandaController', 'action' => 'pesquisarProEst']);
$router->add('resp-comanda', ['controller' => 'ComandaController', 'action' => 'gravarComanda']);

//
$router->add('categorias', ['controller' => 'CategoriaController', 'action' => 'categoriaAdd']);


// $router->add('nova', ['controller' => 'Home', 'action' => 'nova']);
$router->add('{controller}/{action}');


//Rotas fora da sessao
session_start();

if(!isset($_SESSION['usuario']) && !in_array($_SERVER['REQUEST_URI'],['/login', '/registro'])) {
    header('Location: /login');
    exit;
}
$router->dispatch($_SERVER['REQUEST_URI']);
// $router->dispatch($_SERVER['QUERY_STRING']);