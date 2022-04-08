<?php

namespace App\Controller;

use App\Repository\CategoriaDAO;
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
        $obCategoriaDAO = new CategoriaDAO();
        $resp = $obCategoriaDAO->tabCategoria();

       die(var_dump(['categorias'=>$resp]));
        View::renderTemplate('/categorias/tabcategoria.html', ['categorias'=>$resp]); 
    }

}