<?php

namespace App\Controller;

use App\Repository\EstoqueDAO;
use App\Repository\PdvDAO;
use Core\View;
use DateTimeZone;

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
        // die(var_dump($_POST));
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obPdvDAO = new PdvDAO;
            $obEstoqueDAO = new EstoqueDAO;
            
            $id_usuario=$_SESSION['usuario']->getId();
            date_default_timezone_set("America/Sao_Paulo");
            $datetime = date("Y-m-d H:i:s");

            $comandaFatura=array(
                'id_caixa'=> $id_usuario,
                'numero' => $_POST['numero'],
                'cliente' => $_POST['cliente'],
                'formaPgUm' => intval($_POST['pg_forma1']),
                'valorTotalUm' => $_POST['valor_total1'],
                'formaPgDois' => intval($_POST['pg_forma2']),
                'valorTotalDois' => $_POST['valor_total2'],
                'vzsCartao' => intval($_POST['vzs_cartao']),
                'dataFinalizacao' => $datetime
            );
            if($_POST['numero'] == ""){
                unset($comandaFatura['numero']);
            }
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

            if($_POST['numero'] == ""){
                $respComandaFatura=$obPdvDAO->gravarComandaFaturaSemNumero($comandaFatura);
            }else{
                $respComandaFatura=$obPdvDAO->gravarComandaFatura($comandaFatura);
            }
            // die(var_dump($respComandaFatura));
            if($respComandaFatura > 0){
                foreach($_POST['linhas'] as $row) {
                    $linhaFatura=array(
                        'id_comanda_fatura'=>$respComandaFatura,
                        'id_produto'=>$row['id_produto'],
                        'quantidade'=>$row['quantidade'],
                        'quant_estoque'=>$row['quant_estoque'],
                        'valor_unitario'=>$row['valor_unitario'],
                    );
                    $resp = $obPdvDAO->gravarLinhaFatura($linhaFatura);
                    
                    if($resp){
                        $obEstoque = $obEstoqueDAO->retornaProdEst($row['id_produto']);

                        if($obEstoque){
                            $obEstoque->diminuiQuantidade($row['quantidade']);
                            $dados=array(
                                'idEstoque'=>$obEstoque->getId(),
                                'quantotal'=> $obEstoque->getQuantotal()
                            ); 
                            $obEstoqueDAO->baixaEstoque($dados);
                            View::jsonResponse(['resp'=>true]);

                        }else{
                            View::jsonResponse(['resp'=>false]);
                        }

                    }else{
                        View::jsonResponse(['resp'=>false]);
                    }
                }
            }
        }
    }

    /**
     * Apaga produto a tabela temporaria
     */
    public function apagarProdutoComanda()
    {
        $obPdvDAO = new PdvDAO();

        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

            parse_str(file_get_contents("php://input"), $post);

            $respDeletarProduto = $obPdvDAO->deletarProdutoComanda($post['id_comanda_fatura']);
            
            View::jsonResponse($respDeletarProduto);
            
        }
    }
}