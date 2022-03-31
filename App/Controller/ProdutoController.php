<?php

namespace App\Controller;

use App\Repository\ProdutoDAO;
use Core\View;

class ProdutoController 
{
    public function produtoForm()
    {
        $obProduto = new ProdutoDAO;

        try{
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $iduser=$_SESSION['usuario']->getId();
    
                $dados=array();
    
                $nomeImg=$_FILES['imagem']['name'];
                $urlArmazenamento=$_FILES['imagem']['tmp_name'];
                $pasta='arquivos/';
                $urlFinal=$pasta.$nomeImg;
    
                $dadosImg=array(
                    //$_POST['categoriaSelect'],
                    'nome'=>$nomeImg,
                    'url'=>$urlFinal
                );
    
                if(move_uploaded_file($urlArmazenamento, $urlFinal)){
                    $idimagem=$obProduto->addImagem($dadosImg);

                    if($idimagem > 0){
                        //$dados[0]=$_POST['categoriaSelect'];
                        $dados['idImagem']=$idimagem;
                        $dados['idUsuario']=$iduser;
                        $dados['nome']=$_POST['nome'];
                        $dados['descricao']=$_POST['descricao'];
                        return $obProduto->addProduto($dados);
                    }else{
                        return 0;
                    }
                }
            }

        }catch(\Exception $e){
            return $e->getMessage();
        }

        

        View::renderTemplate('/produtos/produto/produtoForm.html'); 
    }

}