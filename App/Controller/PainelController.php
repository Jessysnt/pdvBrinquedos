<?php

namespace App\Controller;

use App\Repository\PainelDAO;
use Core\View;

class PainelController
{
    public function painel()
    {
        $painelDAO = new PainelDAO();
        $resp = $painelDAO->vendasMesAno();
        View::renderTemplate('/painel/inicio.html', ['datas'=>$resp]);
    }
}
