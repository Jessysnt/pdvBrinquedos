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

            if($respNumero > 0){
                $obProdutoLinha = intval($respNumero['id']);

                $respProdutoLinha = $obPdvDAO->verProdutoLinha($obProdutoLinha);

                $resp = $respNumero;
                $resp['linhas'] = $respProdutoLinha;

                View::jsonResponse($resp);

            }else{
                View::jsonResponse(false);
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
                        'id_comanda_fatura'=>intval($respComandaFatura['id']),
                        'id_produto'=>$row['id_produto'],
                        'quantidade'=>$row['quantidade'],
                        'valor_unitario'=>$row['valor_unitario'],
                    );
                    $resp = $obPdvDAO->gravarLinhaFatura($linhaFatura);
                }
                View::jsonResponse(['gravarComanda'=>$resp]);
            }
        }
    }

    public function apagarProdutoComanda()
    {
        $obPdvDAO = new PdvDAO();

        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

            parse_str(file_get_contents("php://input"), $post);

            $dados=array(
                'id_comanda_fatura'=>$post['id_comanda_fatura'],
                'id_produto'=>$post['id_produto'],
            );
            // die(var_dump($dados));
            $resp = $obPdvDAO->deletarProdutoComanda($dados);
              
            View::jsonResponse($resp);
        }
    }
}