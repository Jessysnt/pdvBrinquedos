<?php

namespace App\Controller;

use App\Repository\LancamentoDAO;
use Core\View;

class LancamentosController
{
    public function tabelaVisual()
    {
        View::renderTemplate('/lancamentos/tabelas.html'); 
    }

    public function formulario()
    {
        $obLancamentoDAO = new LancamentoDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_usuario=$_SESSION['usuario']->getId();
            $obLancamento=array(
                'descricao' => $_POST['descricao'],
                'data' => $_POST['data'],
                'valor' => $_POST['valor'],
                'usuario' => $id_usuario
            ); 
            $result = $obLancamentoDAO->adicionarLancamento($obLancamento);
            View::jsonResponse($result);
        }
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
        $resp = $obLancamentoDAO->tabLancamento($busca, $pagina, $itensPag);
        $total = $obLancamentoDAO->qntTotalLancamento($busca);
        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/lancamentos/lancamento-tabela.html', ['lancamentos'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/lancamento-tabela', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }

    public function dadosMes()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obLancamentoDAO = new LancamentoDAO();
            $respMes = $obLancamentoDAO->somaEntreDatas($_POST['dtInicial']);
            $return = ['label'=>array_column($respMes,'dia'),'data'=>array_map('floatval',array_column($respMes,'Total'))];
            View::jsonResponse($return);
        }
        
    }
}