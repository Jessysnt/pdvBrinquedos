<?php

namespace App\Controller;

use App\Repository\ClienteDAO;
use Core\View;

class ClienteController
{
    public function clienteAdd()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obClienteDAO = new ClienteDAO();
            $resp = $obClienteDAO->adicionarCliente($_POST);
            View::jsonResponse($resp);
        }
        View::renderTemplate('/clientes/cliente.html'); 
    }

    public function tabelaClientes()
    {
        $busca= "";
        $pagina= 1;
        $itensPag= 10;

        if(isset($_GET['busca'])){
            $busca = $_GET['busca'];
        }
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }
        if(isset($_GET['itensPag'])){
            $itensPag = $_GET['itensPag'];
        }
        
        $obClienteDAO = new ClienteDAO();
        $resp = $obClienteDAO->tabClientes($busca, $pagina, $itensPag);
        $total = $obClienteDAO->qntTotalClientes($busca);
        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/clientes/tabelaCliente.html', ['clientes'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/cliente-tabela', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }

    public function inativarCliente()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obClienteDAO = new ClienteDAO();
            $resp = $obClienteDAO->inativarCliente($_POST["idcliente"]);
            View::jsonResponse($resp);
        }
    }

    /**
     * Tras o cliente para a modal de atualizar
     */
    public function obterCliente(){
        $obClienteDAO = new ClienteDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obClienteDAO->obterCliente($_POST);
            View::jsonResponse($resp);
        }
    }

    public function atualizarCliente()
    {
        $obClienteDAO = new ClienteDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obClienteDAO->atualizarCliente($_POST);
            View::jsonResponse($resp);
        }
    }

    /**
     * Tras o cliente para a tela de relatorio
     */
    public function clienteVendas()
    {   
        $obClienteDAO = new ClienteDAO();
        if($_GET['cliente']){
            $resp = $obClienteDAO->exibirCliente(intval($_GET["cliente"]));
            View::renderTemplate('/clientes/cliente-venda.html', ['cliente'=>$resp]); 
        }
    }

    public function relatorioVendasCliente()
    {
        $obClienteDAO = new ClienteDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $cliente=array(
                'idCliente'=> intval($_POST['idCliente']),
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respVendasGeral = $obClienteDAO->vendaClienteData($cliente);
            $respVendasProdutos = $obClienteDAO->vendaCliente($cliente);
            View::jsonResponse(['dados'=>$respVendasGeral, 'cliente'=>$respVendasProdutos]);
            View::renderTemplate('/clientes/cliente-venda.html', ['cliente'=>$respVendasProdutos]); 
            // if($cliente){
            //     View::renderTemplate('/clientes/cliente-venda.html', ['cliente'=>$respVendasProdutos]); 
            // }
        }
    }
}