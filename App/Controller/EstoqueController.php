<?php

namespace App\Controller;

use App\Repository\EstoqueDAO;
use Core\View;

class EstoqueController
{
    public function estoque()
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

        $obEstoque = new EstoqueDAO();
        $resp = $obEstoque->mostrarEstoque($busca, $pagina, $itensPag);
        $total = $obEstoque->qntTotalEstoque($busca);

        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/produtos/estoque/estoque.html', ['estoques'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/estoque', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }
}
