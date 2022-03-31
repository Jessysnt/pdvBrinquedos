<?php

namespace App\Controller;

use App\Repository\ProdutoDAO;
use App\Repository\UsuarioDAO;
use Core\View;

class ProdutoVendaController
{
    public function produtoAdd()
    {
        View::renderTemplate('/produtos/produto-venda/produtoVenda.html'); 
    }

    public function mostrarProdutos()
    {
        $obProduto = new ProdutoDAO();
        $resp = $obProduto->exibirProdutos();

        View::renderTemplate('/produtos/produto-venda/produtoVenda.html', ['produtos'=>$resp]); 
    }
}