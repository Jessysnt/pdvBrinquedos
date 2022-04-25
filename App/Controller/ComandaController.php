<?php

namespace App\Controller;

use App\Repository\ComandaDAO;
use App\Repository\ClienteDAO;
use App\Repository\PdvDAO;
use App\Repository\ProdutoDAO;
use Core\View;
use PDOException;

class ComandaController
{
    public function telaInicial()
    {
        View::renderTemplate('/comandas/comanda.html');
    }

    public function pesquisarProd()
    {   
        $obProdutoDAO = new ProdutoDAO();
        $prod = $obProdutoDAO->pesquisarProdutos($_GET['term']);
        //die(var_dump($prod));
        View::jsonResponse(['results'=>$prod]);
    }

    public function pesquisarCli()
    {
        $obClienteDAO = new ClienteDAO();
        $cli = $obClienteDAO->pesquisarClientes($_GET['term']);

        View::jsonResponse(['results'=>$cli]);
    }

    public function pesquisarProEst()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $idProduto = intval($_POST['id']) ;
            $obProdEstDAO = new ComandaDAO();
            $res = $obProdEstDAO->pesquisarProdutoVenda($idProduto);

            View::jsonResponse($res);
        }
    }

    public function pesquisarProEstCod()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // $codigo = intval($_POST['codigo']) ;
            $obProdEst = new ComandaDAO();
            $res = $obProdEst->pesquisarProdutoVendaCod($_POST['codigo']);

            View::jsonResponse($res);
        }
    }

    public function gravarComanda()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obComandaDAO = new ComandaDAO;

            $id_usuario=$_SESSION['usuario']->getId();
            date_default_timezone_set("America/Sao_Paulo");
            $datetime = date("Y-m-d h:i:sa");
            
            $comandaFatura=array(
                'id_vendedor'=>$id_usuario,
                'numero' => $_POST['numero'],
                'cliente' => $_POST['cliente'],
                'dataRegistro' => $datetime,
            );
            if($_POST['cliente'] == ""){
                unset($comandaFatura['cliente']);
            }

            $respComandaFatura=$obComandaDAO->gravarComandaFatura($comandaFatura);
            
            if($respComandaFatura > 0){
                foreach($_POST['linhas'] as $row) {
                    $linhaFatura=array(
                        'id_comanda_fatura'=>$respComandaFatura,
                        'id_produto'=>$row['id_produto'],
                        'quantidade'=>$row['quantidade'],
                        'valor_unitario'=>$row['valor_unitario'],
                    );
                    $obComandaDAO->gravarLinhaFatura($linhaFatura);
                }
                View::jsonResponse(['resp'=>true]);
            }
        }
    }

    /**
     * Verifica se a comanda esta aberta, e tras os dados caso queira editar
     */
    public function numeroAberto()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obComandaDAO = new ComandaDAO;
            $obPdvDAO = new PdvDAO;
            
            $respNumero=$obComandaDAO->verEstaAberta($_POST['numero']);

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
    
}