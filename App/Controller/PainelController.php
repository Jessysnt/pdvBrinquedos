<?php

namespace App\Controller;

use App\Repository\PainelDAO;
use Core\View;

class PainelController
{
    public function painel()
    {
        $id_usuario=$_SESSION['usuario']->getAcessos();
        if($id_usuario = 16){
            View::renderTemplate('/painel/inicio-adm.html');
        }else{
            View::renderTemplate('/painel/inicio.html');
        }
        // $painelDAO = new PainelDAO();
        // $respAno = $painelDAO->vendasMesAno();
        // View::renderTemplate('/painel/inicio.html', ['anos'=>$respAno]);
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
