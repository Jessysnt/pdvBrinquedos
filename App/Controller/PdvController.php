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

    public function gravarComanda()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obPdvDAO = new PdvDAO;

            $id_usuario=$_SESSION['usuario']->getId();
            
            $comandaFatura=array(
                'numero' => $_POST['numero'],
                'cliente' => $_POST['cliente'],
                'formaPgUm' => intval($_POST['pg_forma1']),
                'valorTotalUm' => $_POST['valor_total1'],
                'formaPgDois' => intval($_POST['pg_forma2']),
                'valorTotalDois' => $_POST['valor_total2'],
                'vzsCartao' => intval($_POST['vzs_cartao'])
            );
            
            if($_POST['cliente'] == ""){
                unset($comandaFatura['cliente']);
            }
            if($_POST['pg_forma2'] == ""){
                unset($comandaFatura['formaPgDois']);
                unset($comandaFatura['valorTotalDois']);
            }
            if($_POST['vzs_cartao'] == ""){
                unset($comandaFatura['vzsCartao']);
            }
            
            $respComandaFatura=$obPdvDAO->gravarComandaFatura($comandaFatura);
           
            if($respComandaFatura > 0){

                foreach($_POST['linhas'] as $row) {
                    $linhaFatura=array(
                        'id_comanda_fatura'=>$respComandaFatura,
                        'id_produto'=>$row['id_produto'],
                        'quantidade'=>$row['quantidade'],
                        'valor_unitario'=>$row['valor_unitario'],
                    );
                    // die(var_dump($linhaFatura));
                   $obPdvDAO->gravarLinhaFatura($linhaFatura);
                }
                View::jsonResponse(['resp'=>true, 'linhaFatura'=>$linhaFatura]);
            }
        }
    }
}