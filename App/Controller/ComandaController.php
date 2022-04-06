<?php

namespace App\Controller;

use App\Repository\ComandaDAO;
use App\Repository\ClienteDAO;
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
            
            $comandaFatura=array(
                'id_usuario'=>$id_usuario,
            );
            if($_POST['numero'] != ""){
                $comandaFatura['numero'] = $_POST['numero'];
            }else{
                $comandaFatura['id_cliente'] = $_POST['cliente'];
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
    
}