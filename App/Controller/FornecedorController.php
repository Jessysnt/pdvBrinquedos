<?php

namespace App\Controller;

use App\Repository\FornecedorDAO;
use Core\View;

class FornecedorController
{
    public function fornecedor()
    {   
        $obFornecedorDAO = new FornecedorDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $result = $obFornecedorDAO->adicionarFornecedor($_POST);
            View::jsonResponse($result);
        }
        View::renderTemplate('/fornecedores/fornecedor.html');
    }

    public function tabelaFornecedor()
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

        $obFornecedorDAO = new FornecedorDAO();
        $resp = $obFornecedorDAO->tabFornecedor($busca, $pagina, $itensPag);
        $total = $obFornecedorDAO->qntTotalFornecedor($busca);

        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/fornecedores/tabela-fornecedor.html', ['fornecedores'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/tabela-fornecedor', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }

    public function obterFornecedor()
    {
        $obFornecedorDAO = new FornecedorDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obFornecedorDAO->obterFornecedor(intval($_POST["idfornecedor"]));
            View::jsonResponse($resp);
        }
    }

    public function atualizarFornecedor()
    {
        $obFornecedorDAO = new FornecedorDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $fornecedor = array(
                'id' => intval($_POST['idfornecedorU']),
                'razao_social' => $_POST['razao_socialU'],
                'fantasia' => $_POST['fantasiaU'],
                'cnpj' => $_POST['cnpjU'],
                'email' => $_POST['emailU'],
                'telefone' => $_POST['telefoneU'],
                'rua' => $_POST['ruaU'],
                'numero' => $_POST['numeroU'],
                'bairro' => $_POST['bairroU'],
                'cep' => $_POST['cepU'],
                'cidade' => $_POST['cidadeU'],
                'estado' => $_POST['estadoU']
            );
            $resp = $obFornecedorDAO->atualizaFornecedor($fornecedor);
            View::jsonResponse($resp);
        }
    }

    public function apagarFornecedor()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obFornecedorDAO = new FornecedorDAO();
            $resp = $obFornecedorDAO->apagarFornecedor(intval($_POST["idfornecedor"]));
            View::jsonResponse($resp);
        }
    }
}