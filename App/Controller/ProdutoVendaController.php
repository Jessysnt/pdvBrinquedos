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
        $obProdVenda = new ProdutoVendaDAO;
        $obEstoque = new EstoqueDAO;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $idusuario=$_SESSION['usuario']->getId();
            
            $dadosP=array(
                $idusuario,
                $_POST['produtoSelect'],
                $_POST['lote'],
                $_POST['quantidade'],
                $_POST['comp'],
                $_POST['ven']
            );
            $idprodv=$obProdVenda->adicionarProdVenda($dadosP);
        
            
        
            if($idprodv > 0){
                
                while ($obEstoque):
                    if($_POST['produtoSelect'] == $obEstoque[1]){
        
                        $dados=array(
                            $dados['idEstoque']=$obEstoque[0],
                            $dados['idProduto']=$_POST['produtoSelect'],
                            $dados['quantotal']=$_POST['quantidade'],
                            $dados['precoVenda']=$_POST['ven'],
                            $dados['quantEst']=$obEstoque[2]
                        ); 
                        return $obEstoque->atualizaProdEstoque($dados);
                        break;
                    } 
                endwhile;
                
                if($obEstoque == null){
                    $dados=array(
                        $dados['idProduto']=$_POST['produtoSelect'],
                        $dados['quantotal']=$_POST['quantidade'],
                        $dados['precoVenda']=$_POST['ven']
                    );
                    return $obEstoque->addProdEstoque($dados);
                }		
        
            }else{
                    return 0;
            }
                
            //View::jsonResponse($result);
        }
    }
    
}