<?php

namespace App\Controller;

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
                //die(var_dump('resp',$resp));
                $obEstoque = $obEstoqueDAO->retornaProdEst($_POST['produtoSelect']);
                
                if($obEstoque){
                    
                    $obEstoque->acrescentaQuantidade($_POST['quantidade']);
                    //die(var_dump('ak1', $obEstoque));
                    $teste = $obEstoque->verificaPrecoVenda($_POST['ven']);
                    
                    $dados=array(
                        'idEstoque'=>$obEstoque->getId(),
                        'quantotal'=> $obEstoque->getQuantotal(),
                        'precoVenda'=>$teste
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
    
}