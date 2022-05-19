<?php

namespace App\Controller;

use App\Repository\PainelDAO;
use Core\View;

class PainelController
{
    public function painel()
    {
        $painelDAO = new PainelDAO();
        $respAno = $painelDAO->vendasMesAno();
        View::renderTemplate('/painel/inicio.html', ['anos'=>$respAno]);
    }

    public function dadosMes()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $painelDAO = new PainelDAO();
            $respMes = $painelDAO->datasMesAno($_POST['dtInicial']);
            $return = ['label'=>array_column($respMes,'dia'),'data'=>array_map('floatval',array_column($respMes,'Total'))];
            View::jsonResponse($return);
        }
        
    }
}
