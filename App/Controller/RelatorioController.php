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
        View::renderTemplate('/relatorios/comanda-status.html');
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
}