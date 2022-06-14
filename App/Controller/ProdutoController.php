<?php

namespace App\Controller;

use App\Repository\CategoriaDAO;
use App\Repository\ProdutoDAO;
use Core\View;

class ProdutoController 
{
    public function produtoForm()
    {
        $obProduto = new ProdutoDAO();
        $obCategoriaDAO = new CategoriaDAO();
        $categoria = $obCategoriaDAO->pesquisarCategorias();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario=$_SESSION['usuario']->getId();
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
                    $dados['idImagem']=$idimagem;
                    $dados['idCategoria']=$_POST['categoria'];
                    $dados['idUsuario']=$usuario;
                    $dados['codigo']=$_POST['codigo'];
                    $dados['nome']=$_POST['nome'];
                    $dados['descricao']=$_POST['descricao'];
                    $obProduto->addProduto($dados);
                    View::jsonResponse(['resp'=>true, 'idimagem'=>$idimagem]);
                }else{
                    View::jsonResponse(['resp'=>false]);
                }
            }
        }     
        View::renderTemplate('/produtos/produto/produtoForm.html', ['categorias'=>$categoria]); 
    }

    public function tabelaProduto()
    {
        $busca= "";
        $pagina= 1;
        $itensPag= 10;

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
    
    /**
     * Tras o produto para a modal de atualizar
     */
    public function obterProduto(){
        $obProdutoDAO = new ProdutoDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obProdutoDAO->obterProduto($_POST['id']);
            View::jsonResponse($resp);
        }
    }

    public function atualizarProduto()
    {
        $ProdutoDAO = new ProdutoDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $ProdutoDAO->atualizarProduto($_POST);
            View::jsonResponse($resp);
        }
    }

    public function apagarProduto()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $ProdutoDAO = new ProdutoDAO();
            $resp = $ProdutoDAO->excluirProduto($_POST['id']);
            View::jsonResponse($resp);
        }
    }

    public function pesquisarProd()
    {
        $obProdutoDAO = new ProdutoDAO();
        $prod = $obProdutoDAO->pesquisarProdutos($_GET['term']);
        View::jsonResponse(['results'=>$prod]);
    }

}