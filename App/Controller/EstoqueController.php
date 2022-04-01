<?php

namespace App\Controller;

use App\Repository\EstoqueDAO;
use Core\View;

class EstoqueController
{
    public function estoque()
    {
        $obEstoque = new EstoqueDAO();
        $resp = $obEstoque->mostrarEstoque();

        View::renderTemplate('/produtos/estoque/estoque.html', ['estoques'=>$resp]);
    }
}