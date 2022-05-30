<?php

namespace App\Controller;

use App\Repository\LancamentoDAO;
use Core\View;

class LancamentosController
{
    public function formulario()
    {
        View::renderTemplate('/lancamentos/lancamentos.html'); 
    }

    public function tabelaLancamentos()
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

        $obLancamentoDAO = new LancamentoDAO();
        $resp = $obLancamentoDAO->tabUsuario($busca, $pagina, $itensPag);
        $total = $obLancamentoDAO->qntTotalUsuarios($busca);
        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/lancamentos/lancamento-tabela.html', ['lancamentos'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/tab-usuario', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }
}