<?php

namespace App\Controller;
use Core\View;

class ManualController
{
    /**
     * 
     */
    public function index()
    {   
        View::renderTemplate('mkdocs/introducao.html.twig');
    }
    

    public function _introducao()
    {
        View::renderTemplate('mkdocs/introducao.html.twig');
    }
    

    public function _inicio()
    {
        View::renderTemplate('mkdocs/inicio.html.twig');
    }
    

    public function _colaborador()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(6, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/colaborador.html.twig');
        
    }
    

    public function _categorias()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(10, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/categorias.html.twig');
    }
    

    public function _produtos()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(9, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/produtos.html.twig');
    }
    

    public function _lote()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(11, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/lote.html.twig');
    }
    

    public function _estoque()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(12, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/estoque.html.twig');
    }
    

    public function _cliente()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(1, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/cliente.html.twig');
    }
    

    public function _abrir_comanda()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(13, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/abrir-comanda.html.twig');
    }
    

    public function _pdv_ponto_de_venda()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(14, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/pdv-ponto-de-venda.html.twig');
    }
    

    public function _lancamentos()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(18, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/lancamentos.html.twig');
    }
    

    public function _relatorios()
    {
        $usuario=$_SESSION['usuario']->getAcessos();
        if(!in_array(19, $usuario))
        {
            View::renderTemplate('mkdocs/permissao.html.twig');
            return false;
        }
        View::renderTemplate('mkdocs/relatorios.html.twig');
    }
    
}