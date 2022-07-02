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
$router->add('sair', ['controller' => 'LoginController', 'action' => 'sair'],);

//Rotas de Usuario
$router->add('usuario-add', ['controller' => 'UsuarioController', 'action' => 'usuarioAdd', 'acesso' => 11]);
$router->add('tab-usuario', ['controller' => 'UsuarioController', 'action' => 'tabelaUsuario']);
$router->add('obt-usuario', ['controller' => 'UsuarioController', 'action' => 'obterUsuario']);
$router->add('apg-usuario', ['controller' => 'UsuarioController', 'action' => 'inativarUsuario']);
$router->add('atz-usuario', ['controller' => 'UsuarioController', 'action' => 'atualizaUsuario']);
$router->add('usuario-venda', ['controller' => 'UsuarioController', 'action' => 'usuarioVendas']);
$router->add('usuario-relatorio-venda', ['controller' => 'UsuarioController', 'action' => 'relatorioVendasUsuario']);

//Rotas de Cliente
$router->add('cliente-add', ['controller' => 'ClienteController', 'action' => 'clienteAdd']);
$router->add('cliente-tabela', ['controller' => 'ClienteController', 'action' => 'tabelaClientes']);
$router->add('cliente-obter', ['controller' => 'ClienteController', 'action' => 'obterCliente']);
$router->add('cliente-inativar', ['controller' => 'ClienteController', 'action' => 'inativarCliente']);
$router->add('cliente-atualizar', ['controller' => 'ClienteController', 'action' => 'atualizarCliente']);
$router->add('cliente-venda', ['controller' => 'ClienteController', 'action' => 'clienteVendas']);
$router->add('cliente-relatorio-venda', ['controller' => 'ClienteController', 'action' => 'relatorioVendasCliente']);


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
$router->add('pesquisar-produto', ['controller' => 'ProdutoController', 'action' => 'pesquisarProd']);
$router->add('pesquisar-cliente', ['controller' => 'ComandaController', 'action' => 'pesquisarCli']);
$router->add('pesquisar-prod-est', ['controller' => 'ComandaController', 'action' => 'pesquisarProEst']);
$router->add('pesquisar-prod-est-codigo', ['controller' => 'ComandaController', 'action' => 'pesquisarProEstCod']);
$router->add('pesquisar-select', ['controller' => 'ComandaController', 'action' => 'pesquisarIdProdEst']);
$router->add('gravar-comanda', ['controller' => 'ComandaController', 'action' => 'gravarComanda']);
$router->add('ver-aberto', ['controller' => 'ComandaController', 'action' => 'numeroAberto']);
$router->add('apaga-prods-comanda', ['controller' => 'ComandaController', 'action' => 'apagarProdutoComanda']);
$router->add('finaliza-comanda', ['controller' => 'ComandaController', 'action' => 'finalizarComanda']);

//Rotas do PDV
$router->add('pdv', ['controller' => 'PdvController', 'action' => 'telaInicial']);
$router->add('obter-dados-numero', ['controller' => 'PdvController', 'action' => 'obterDadosNumero']);
$router->add('gravar-venda', ['controller' => 'PdvController', 'action' => 'gravarComanda']);
$router->add('apaga-prod-comanda', ['controller' => 'PdvController', 'action' => 'apagarProdutoComanda']);
$router->add('pesq-cliente-comanda', ['controller' => 'PdvController', 'action' => 'pesqClienteComanda']);
$router->add('permissao-desconto', ['controller' => 'PdvController', 'action' => 'verificaPermissaoDesconto']);
$router->add('comprovante-venda', ['controller' => 'PdvController', 'action' => 'impressaoVenda']);

//Rotas de Categoria
$router->add('categorias', ['controller' => 'CategoriaController', 'action' => 'categoriaAdd']);
$router->add('tabela-categoria', ['controller' => 'CategoriaController', 'action' => 'tabelaCategorias']);
$router->add('atualizar-categoria', ['controller' => 'CategoriaController', 'action' => 'atualizarCategoria']);
$router->add('obter-categoria', ['controller' => 'CategoriaController', 'action' => 'obterCategoria']);

//Rotas de Fornecedor
$router->add('adicionar-fornecedor', ['controller' => 'FornecedorController', 'action' => 'fornecedor']);
$router->add('tabela-fornecedor', ['controller' => 'FornecedorController', 'action' => 'tabelaFornecedor']);
$router->add('obter-fornecedor', ['controller' => 'FornecedorController', 'action' => 'obterFornecedor']);
$router->add('atualizar-fornecedor', ['controller' => 'FornecedorController', 'action' => 'atualizarFornecedor']);
$router->add('apagar-fornecedor', ['controller' => 'FornecedorController', 'action' => 'apagarFornecedor']);

//Rotas do Painel
$router->add('painel', ['controller' => 'PainelController', 'action' => 'painel']);

//Rotas do Dashboard
$router->add('dashboard', ['controller' => 'DashboardController', 'action' => 'inicio']);
$router->add('venda-mes', ['controller' => 'DashboardController', 'action' => 'painelAdm']);
$router->add('pesquisa-mes', ['controller' => 'DashboardController', 'action' => 'dadosVendaMes']);
$router->add('pesquisa-ano-entrada-saida', ['controller' => 'DashboardController', 'action' => 'dadosEntradaSaida']);

//Rotas de Relatorios
$router->add('mais-vendidos-produto', ['controller' => 'RelatorioController', 'action' => 'produtosMaisVendidos']);
$router->add('comanda-status', ['controller' => 'RelatorioController', 'action' => 'pesquisaComandas']);
$router->add('pesquisa-comanda', ['controller' => 'RelatorioController', 'action' => 'comanda']);
$router->add('fechar-comanda', ['controller' => 'RelatorioController', 'action' => 'fecharComanda']);
$router->add('colaboradores-vendas', ['controller' => 'RelatorioController', 'action' => 'colaboradoresVendas']);
$router->add('status-anual', ['controller' => 'RelatorioController', 'action' => 'verLancamentoVenda']);
$router->add('pesquisar-vendas', ['controller' => 'RelatorioController', 'action' => 'vendaPeriodo']);

//Rotas de lançamentos
$router->add('lancamento', ['controller' => 'LancamentosController', 'action' => 'formulario']);
$router->add('lancamento-tabela', ['controller' => 'LancamentosController', 'action' => 'tabelaLancamentos']);

//Rotas impressao pdf
$router->add('pdf-vendas', ['controller' => 'RelatorioController', 'action' => 'vendasPdf']);
$router->add('pdf-status-anual', ['controller' => 'RelatorioController', 'action' => 'verLancamentoVendaPdf']);
$router->add('pdf-mais-vendidos', ['controller' => 'RelatorioController', 'action' => 'produtosMaisVendidosPdf']);
$router->add('pdf-colaboradores-vendas', ['controller' => 'RelatorioController', 'action' => 'colaboradoresVendasPdf']);

//Rotas manual
$router->add('manual/introducao', ['controller' => 'ManualController', 'action' => '_introducao']); 
$router->add('manual/inicio', ['controller' => 'ManualController', 'action' => '_inicio']); 
$router->add('manual/colaborador', ['controller' => 'ManualController', 'action' => '_colaborador']); 
$router->add('manual/categorias', ['controller' => 'ManualController', 'action' => '_categorias']); 
$router->add('manual/produtos', ['controller' => 'ManualController', 'action' => '_produtos']); 
$router->add('manual/lote', ['controller' => 'ManualController', 'action' => '_lote']); 
$router->add('manual/estoque', ['controller' => 'ManualController', 'action' => '_estoque']); 
$router->add('manual/cliente', ['controller' => 'ManualController', 'action' => '_cliente']); 
$router->add('manual/abrir-comanda', ['controller' => 'ManualController', 'action' => '_abrir_comanda']); 
$router->add('manual/pdv-ponto-de-venda', ['controller' => 'ManualController', 'action' => '_pdv_ponto_de_venda']); 
$router->add('manual/lancamentos', ['controller' => 'ManualController', 'action' => '_lancamentos']); 
$router->add('manual/relatorios', ['controller' => 'ManualController', 'action' => '_relatorios']);

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