<?php

namespace App\Controller;

use App\Repository\PdvDAO;
use Core\View;

class PdvController
{
    public function telaInicial()
    {
        View::renderTemplate('/pdv/pdv.html');
    }

    public function obterDadosNumero()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obPdvDAO = new PdvDAO;
            
            $respNumero=$obPdvDAO->verEstaAberta($_POST['numero']);

            if(count($respNumero) > 0){
                $obProdutoLinha = intval($respNumero[0]['id']);

                $respProdutoLinha = $obPdvDAO->verProdutoLinha($obProdutoLinha);

                $resp = $respNumero[0];
                $resp['linhas'] = $respProdutoLinha;

                View::jsonResponse(['resp'=>$resp]);

            }else{
                View::jsonResponse(['resp'=>false]);
            }

        }
    }
}