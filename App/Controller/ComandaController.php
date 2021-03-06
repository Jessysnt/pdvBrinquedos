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

    public function pesquisarIdProdEst()
    {   
        $obProdutoDAO = new ProdutoDAO();
        $prod = $obProdutoDAO->pesquisarProdutoEstoque($_GET['term']);
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
            $datetime = date("Y-m-d H:i:s");
            
            $comandaFatura=array(
                'id'=>$_POST['id'],
                'id_vendedor'=>$id_usuario,
                'numero' => $_POST['numero'],
                'cliente' => $_POST['cliente'],
                'dataRegistro' => $datetime,
            );
            if($_POST['cliente'] == ""){
                unset($comandaFatura['cliente']);
            }
            if($_POST['id'] == ""){
                unset($comandaFatura['id']);
            }
            if($_POST['id']){
                $respComandaFatura=$obComandaDAO->updateComandaFatura($comandaFatura);
            }else{
                $respComandaFatura=$obComandaDAO->gravarComandaFatura($comandaFatura);
            }
            
            $deleteLinhaFatura=$obComandaDAO->deletarLinhaFatura($respComandaFatura);
            
            if($respComandaFatura > 0){
                foreach($_POST['linhas'] as $row) {
                    $linhaFatura=array(
                        'id_comanda_fatura'=>$respComandaFatura,
                        'id_produto'=>$row['id_produto'],
                        'quantidade'=>$row['quantidade'],
                        'valor_unitario'=>$row['valor_unitario'],
                    );
                    $obComandaDAO->gravarLinhaFaturaInsert($linhaFatura);
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
        $obComandaDAO = new ComandaDAO();
            $obPdvDAO = new PdvDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            date_default_timezone_set("America/Sao_Paulo");
            $datetime = date("Y-m-d");
            $comanda=array(
                'numero'=> $_POST['numero'],
                'dtInicial'=> $datetime,
                'dtFinal'=> $datetime
            );
            $respNumero=$obComandaDAO->verEstaAberta($comanda);
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

    /**
     * Apaga produto a tabela temporaria
     */
    public function apagarProdutoComanda()
    {
        $obComandaDAO = new ComandaDAO();
        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            parse_str(file_get_contents("php://input"), $post);
            $respDeletarProduto = $obComandaDAO->deletarProdutoComanda($post['id_comanda_fatura']);
            View::jsonResponse($respDeletarProduto);
        }
    }

    public function finalizarComanda()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obComandaDAO = new ComandaDAO();
            $respLinha = $obComandaDAO->fecharLinhaFatura($_POST['comanda']);
            $resp = $obComandaDAO->fecharComanda($_POST['comanda']);
            View::jsonResponse($resp);
        }
    }
    
}