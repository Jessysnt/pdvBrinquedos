<?php

namespace App\Controller;

use App\Entity\Estoque;
use App\Repository\EstoqueDAO;
use App\Repository\ProdutoDAO;
use App\Repository\ProdutoVendaDAO;
use Core\View;

class ProdutoVendaController
{
    public function produtoVenda()
    {
        $obProduto = new ProdutoDAO();
        $resp = $obProduto->exibirProdutos();
        //die(var_dump($resp));
        View::renderTemplate('/produtos/produto-venda/produtoVenda.html', ['produtos'=>$resp]); 
    }

    public function produtoAdd()
    {
        $obProdVendaDAO = new ProdutoVendaDAO();
        $obEstoqueDAO = new EstoqueDAO();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $idusuario=$_SESSION['usuario']->getId();
            $dadosP=array(
                'idUsuario'=>$idusuario,
                'idProduto'=>$_POST['produtoSelect'],
                'lote'=>$_POST['lote'],
                'quantotal'=>$_POST['quantidade'],
                'precoComp'=>$_POST['comp'],
                'precoVenda'=>$_POST['ven']
            );
            $resp=$obProdVendaDAO->adicionarProdVenda($dadosP);
            
            if($resp){
                $obEstoque = $obEstoqueDAO->retornaProdEst($_POST['produtoSelect']);
                if($obEstoque){
                    $obEstoque->acrescentaQuantidade($_POST['quantidade']);
                    $dados=array(
                        'idEstoque'=>$obEstoque->getId(),
                        'quantotal'=> $obEstoque->getQuantotal(),
                        'precoVenda'=>$obEstoque->verificaPrecoVenda($_POST['ven'])
                    ); 
                    $obEstoqueDAO->atualizaProdEstoque($dados);
                    View::jsonResponse(['resp'=>true]);
                }else{
                    $dados=array(
                        'idProduto'=>$_POST['produtoSelect'],
                        'quantotal'=>$_POST['quantidade'],
                        'precoVenda'=>$_POST['ven']
                    );
                    $obEstoqueDAO->addProdEstoque($dados);
                    View::jsonResponse(['resp'=>true]);
                }
        
            }else{
                View::jsonResponse(['resp'=>false]);
            }
                
            //View::jsonResponse($result);
        }
    }

    public function tabelaProdutoVenda()
    {
        $obProdutoVenda = new ProdutoVendaDAO();
        $resp = $obProdutoVenda->produtoVendaTabela();
        View::renderTemplate('/produtos/produto-venda/tabelaProdutoVenda.html', ['produtosVenda'=>$resp]); 
    }

    public function obterProdutoV()
    {
        $obProdutoVendaDAO = new ProdutoVendaDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obProdutoVendaDAO->obterProdutoVenda($_POST);
            View::jsonResponse($resp);
        }
    }

    public function atualizarProdutoVenda()
    {
        $obProdutoVendaDAO = new ProdutoVendaDAO();
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            parse_str(file_get_contents("php://input"), $post);
            date_default_timezone_set("America/Sao_Paulo");
            $datetime = date("Y-m-d H:i:s");

            $editadoProdutoVenda=array(
                'id' => $post[''],
                'idProduto' => $post[''],
                'lote' => $post[''],
                'quantidade' => $post[''],
                'precoComp' => $post[''],
                'precoVend' => $post[''],
                'editado' => $datetime,
            );
            $resp = $obProdutoVendaDAO->atualizarProdutoV($editadoProdutoVenda); 
            View::jsonResponse($resp);
        }
    }

    /**
     * Desativa lote e exclui do estoque
     */
    public function desativarLote()
    {
        $obEstoqueDAO = new EstoqueDAO();
        $obProdutoVendaDAO = new ProdutoVendaDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obEstoque = $obEstoqueDAO->retornaProdEst($_POST['idProduto']);
            if($obEstoque){
                $obEstoque->diminuiQuantidade($_POST['quantidade']);
                $dados=array(
                    'idEstoque'=>$obEstoque->getId(),
                    'quantotal'=> $obEstoque->getQuantotal(),
                    'precoVenda'=>$obEstoqueDAO->retornaMaiorPreco($_POST['idProduto'])
                ); 
                $respEstoque = $obEstoqueDAO->atualizaProdEstoque($dados);
                if($respEstoque){
                    $respProdutoVenda = $obProdutoVendaDAO->inativarProdutoVenda($_POST['idLote']) ;
                    View::jsonResponse($respProdutoVenda);
                }
            }else{
                View::jsonResponse(false);
            }
        }
    }
}