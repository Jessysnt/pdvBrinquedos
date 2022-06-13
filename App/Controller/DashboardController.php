<?php

namespace App\Controller;

use App\Repository\DashboardDAO;
use Core\View;

class DashboardController
{
    public function inicio()
    {
        View::renderTemplate('/painel/inicio-adm.html');
    }

    public function painelAdm()
    {
        $obDashboardDAO = new DashboardDAO();
        $respAno = $obDashboardDAO->vendasMesAno();
        View::renderTemplate('/dashboard/venda-mes.html', ['anos'=>$respAno]);
    }

    public function dadosVendaMes()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obDashboardDAO = new DashboardDAO();
            $respMes = $obDashboardDAO->datasMesAno($_POST['dtInicial']);
            $return = ['label'=>array_column($respMes,'dia'),'data'=>array_map('floatval',array_column($respMes,'Total'))];
            View::jsonResponse($return);
        }
    }

    public function dadosEntradaSaida()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obDashboardDAO = new DashboardDAO();
            $respAno= $obDashboardDAO->vendasAno($_POST['dtInicial']);
            $return = ['label'=>array_column($respAno,'mes'),'entrada'=>array_map('floatval',array_column($respAno,'entradas')), 'saida'=>array_map('floatval',array_column($respAno,'saidas'))];
            View::jsonResponse($return);
        }
        View::renderTemplate('/dashboard/entrada-saida.html');
    }
}
