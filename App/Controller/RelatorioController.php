<?php

namespace App\Controller;

use App\Repository\RelatorioDAO;
use Core\View;

class RelatorioController
{
    public function produtosMaisVendidos()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respProdutosPeriodo = $obRelatorioDAO->maisVendidos($datas);
            View::jsonResponse(['maisVendidos'=>$respProdutosPeriodo]);
        }
        View::renderTemplate('/relatorios/mais-vendidos.html'); 
    }

    public function statusComandas()
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

        $obRelatorioDAO = new RelatorioDAO();
        $resp = $obRelatorioDAO->mostrarComanda($busca, $pagina, $itensPag);
        $total = $obRelatorioDAO->qntTotalComanda($busca);

        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/relatorios/comanda-status.html', ['comandas'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/comanda-status', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }

    public function pesquisaComandas()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respComandas = $obRelatorioDAO->vendaComandas($datas);
            View::jsonResponse(['dados'=>$respComandas]);
        }
    }

    public function dadosMesAno()
    {
        // $obRelatorioDAO = new RelatorioDAO();
        // if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //     $respMes = $obRelatorioDAO->mesAno($_POST['dtInicial']);
        //     $return = ['label'=>array_column($respMes,'dia'),'data'=>array_map('floatval',array_column($respMes,'Total'))];
        //     View::jsonResponse($return);
        // }
        
    }

    public function colaboradoresVendas()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respVendasPeriodo = $obRelatorioDAO->vendasPeriodoColaboradores($datas);
            View::jsonResponse(['colaboradores'=>$respVendasPeriodo]);
        }
        View::renderTemplate('/relatorios/vendas-colaboradores.html'); 
    }
}