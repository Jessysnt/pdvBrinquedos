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
            $datas=array(
                'ano'=>$_POST['dtInicial'],
                'data'=>$_POST['dtInicial'].'-12-01'
            );
            $respAno= $obDashboardDAO->vendasAno($datas);
            $return = ['label'=>array_column($respAno,'mes'),'entrada'=>array_map('floatval',array_column($respAno,'entrada')), 'saida'=>array_map('floatval',array_column($respAno,'saida')), 'saldo'=>array_map('floatval',array_column($respAno,'saldo'))];
            View::jsonResponse($return);
        }
        View::renderTemplate('/dashboard/entrada-saida.html');
    }
}
