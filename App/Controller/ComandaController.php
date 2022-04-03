<?php

namespace App\Controller;

use App\Repository\ComandaDAO;
use App\Repository\ClienteDAO;
use App\Repository\ProdutoDAO;
use Core\View;
use PDOException;

class ComandaController
{
    public function telaInicial()
    {
        View::renderTemplate('/comandas/comanda.html');
    }

    public function pesquisarProd()
    {   
        $obProdutoDAO = new ProdutoDAO();
        $prod = $obProdutoDAO->pesquisarProdutos($_GET['term']);
        //die(var_dump($prod));
        View::jsonResponse(['results'=>$prod]);
    }

    public function pesquisarCli()
    {
        $obClienteDAO = new ClienteDAO();
        $cli = $obClienteDAO->pesquisarClientes($_GET['term']);

        View::jsonResponse(['results'=>$cli]);
    }

    public function pesquisarProEst()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $idProduto = intval($_POST['id']) ;
            $obProdEstDAO = new ComandaDAO();
            $res = $obProdEstDAO->pesquisarProdutoVenda($idProduto);

            View::jsonResponse($res);
        }
    }
    
}