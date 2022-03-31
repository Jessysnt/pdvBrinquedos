<?php

namespace App\Controller;

use App\Repository\ProdutoDAO;
use App\Repository\UsuarioDAO;
use Core\View;

class ProdutoVendaController
{
    public function produtoVenda()
    {
        $obProduto = new ProdutoDAO();
        $resp = $obProduto->exibirProdutos();
        //die(var_dump($resp));
        View::renderTemplate('/produtos/produto-venda/produtoVenda.html', ['produtos'=>$resp]); 
    }
    
}