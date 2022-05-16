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
$router->add('apg-usuario', ['controller' => 'UsuarioController', 'action' => 'inativarUsuario']);
$router->add('atz-usuario', ['controller' => 'UsuarioController', 'action' => 'atualizaUsuario']);
$router->add('usuario-venda', ['controller' => 'UsuarioController', 'action' => 'usuarioVendas']);

//Rotas de Cliente
$router->add('cliente-add', ['controller' => 'ClienteController', 'action' => 'clienteAdd']);
$router->add('cliente-tabela', ['controller' => 'ClienteController', 'action' => 'tabelaClientes']);
$router->add('cliente-obter', ['controller' => 'ClienteController', 'action' => 'obterCliente']);
$router->add('cliente-inativar', ['controller' => 'ClienteController', 'action' => 'inativarCliente']);
$router->add('cliente-atualizar', ['controller' => 'ClienteController', 'action' => 'atualizarCliente']);


//Rotas dos Produto
$router->add('produto-form', ['controller' => 'ProdutoController', 'action' => 'produtoForm']);
$router->add('tab-produto', ['controller' => 'ProdutoController', 'action' => 'tabelaProduto']);
$router->add('pesquisar-categoria', ['controller' => 'ProdutoController', 'action' => 'pesquisarCategoria']);
$router->add('produto-obter', ['controller' => 'ProdutoController', 'action' => 'obterProduto']);
$router->add('produto-atualizar', ['controller' => 'ProdutoController', 'action' => 'atualizarProduto']);
$router->add('produto-apagar', ['controller' => 'ProdutoController', 'action' => 'apagarProduto']);

//Rotas Produtos Preço
$router->add('produto-venda', ['controller' => 'ProdutoVendaController', 'action' => 'produtoVenda']);
$router->add('prod-vend-add', ['controller' => 'ProdutoVendaController', 'action' => 'produtoAdd']);
$router->add('tab-prod-vend', ['controller' => 'ProdutoVendaController', 'action' => 'tabelaProdutoVenda']);
$router->add('obt-produtov', ['controller' => 'ProdutoVendaController', 'action' => 'obterProdutoV']);
$router->add('atz-prod-venda', ['controller' => 'ProdutoVendaController', 'action' => 'atualizarProdutoVenda']);
$router->add('apg-prod-ven', ['controller' => 'ProdutoVendaController', 'action' => 'apagarProdutoVenda']);
$router->add('prod-vend-desativa', ['controller' => 'ProdutoVendaController', 'action' => 'desativarLote']);

//Rotas Estoque
$router->add('estoque', ['controller' => 'EstoqueController', 'action' => 'estoque']);

//Rotas de Comandas
$router->add('comandas', ['controller' => 'ComandaController', 'action' => 'telaInicial']);
$router->add('pesquisar-produto', ['controller' => 'ComandaController', 'action' => 'pesquisarProd']);
$router->add('pesquisar-cliente', ['controller' => 'ComandaController', 'action' => 'pesquisarCli']);
$router->add('pesquisar-prod-est', ['controller' => 'ComandaController', 'action' => 'pesquisarProEst']);
$router->add('pesquisar-prod-est-codigo', ['controller' => 'ComandaController', 'action' => 'pesquisarProEstCod']);
$router->add('gravar-comanda', ['controller' => 'ComandaController', 'action' => 'gravarComanda']);
$router->add('ver-aberto', ['controller' => 'ComandaController', 'action' => 'numeroAberto']);
$router->add('apaga-prods-comanda', ['controller' => 'ComandaController', 'action' => 'apagarProdutoComanda']);

//Rotas do PDV
$router->add('pdv', ['controller' => 'PdvController', 'action' => 'telaInicial']);
$router->add('obter-dados-numero', ['controller' => 'PdvController', 'action' => 'obterDadosNumero']);
$router->add('gravar-venda', ['controller' => 'PdvController', 'action' => 'gravarComanda']);
$router->add('apaga-prod-comanda', ['controller' => 'PdvController', 'action' => 'apagarProdutoComanda']);
$router->add('pesq-cliente-comanda', ['controller' => 'PdvController', 'action' => 'pesqClienteComanda']);

//Rotas de Categoria
$router->add('categorias', ['controller' => 'CategoriaController', 'action' => 'categoriaAdd']);
$router->add('tabela-categoria', ['controller' => 'CategoriaController', 'action' => 'tabelaCategorias']);

//Rotas de Fornecedor
$router->add('fornecedores', ['controller' => 'FornecedorController', 'action' => 'fornecedor']);


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