<?php

namespace App\Controller;

use App\Repository\CategoriaDAO;
use App\Repository\ProdutoDAO;
use Core\View;

class CategoriaController
{
    public function categoriaAdd()
    {
        $obCategoriaDAO = new CategoriaDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $result = $obCategoriaDAO->cadastrarCategoria($_POST);
            View::jsonResponse($result);
        }
        View::renderTemplate('/categorias/categoria.html'); 
    }

    public function tabelaCategorias()
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

        $obCategoriaDAO = new CategoriaDAO();
        $resp = $obCategoriaDAO->tabCategoria($busca, $pagina, $itensPag);
        $total = $obCategoriaDAO->qntTotalCategoria($busca);
        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/categorias/tabcategoria.html', ['categorias'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/tabela-categoria', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }

    public function atualizarCategoria()
    {
        $obCategoriaDAO = new CategoriaDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria=array(
                'id' => $_POST['idCategoriaU'],
                'categoria' => $_POST['categoriaU'],
                'descricao' => $_POST['descricaoU']
            );
            $resp = $obCategoriaDAO->atualizaCategoria($categoria);
            View::jsonResponse($resp);
        }
    }

    public function obterCategoria()
    {
        $obCategoriaDAO = new CategoriaDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obCategoriaDAO->obterCategoria(intval($_POST["idcategoria"]));
            View::jsonResponse($resp);
        }
    }

    public function excluirCategoria()
    {
        $obCategoriaDAO = new CategoriaDAO();
        $obProdutoDAO = new ProdutoDAO();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respProduto = $obProdutoDAO->categoriaProduto($_POST['idcategoria']);
            if(!$respProduto){
                $respCategoria = $obCategoriaDAO->apagarCategoria($_POST['idcategoria']);
            }
        }
    }

}