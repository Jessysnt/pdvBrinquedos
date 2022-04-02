<?php

namespace App\Controller;

use App\Repository\ClienteDAO;
use App\Repository\ProdutoDAO;
use Core\View;

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
        $cli = $obClienteDAO->exibirClientes();

        View::jsonResponse($cli);
    }
}