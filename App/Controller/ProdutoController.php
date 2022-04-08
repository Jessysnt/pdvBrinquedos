<?php

namespace App\Controller;

use App\Repository\ProdutoDAO;
use Core\View;

class ProdutoController 
{
    public function produtoForm()
    {
        $obProduto = new ProdutoDAO();

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

                        $obProduto->addProduto($dados);
                        View::jsonResponse(['resp'=>true]);
                    }else{
                        View::jsonResponse(['resp'=>false]);
                    }
                }
            }

        }catch(\Exception $e){
            return $e->getMessage();
        }
        
        View::renderTemplate('/produtos/produto/produtoForm.html'); 
    }

    public function tabelaProduto()
    {
        $busca= "";
        $pagina= 1;
        $itensPag= 1;

        if(isset($_GET['busca'])){
            $busca = $_GET['busca'];
        }
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }
        if(isset($_GET['itensPag'])){
            $itensPag = $_GET['itensPag'];
        }

        $obProduto = new ProdutoDAO();
        $resp = $obProduto->mostrarProduto($busca, $pagina, $itensPag);
        $total = $obProduto->qntTotalProduto($busca);

        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/produtos/produto/tabelaProduto.html', ['produtos'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/tab-produto', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);

    }

}