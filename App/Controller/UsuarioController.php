<?php

namespace App\Controller;

use App\Repository\UsuarioDAO;
use Core\View;

class UsuarioController
{
    public function usuarioAdd()
    {
        $obUsuario = new UsuarioDAO();
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
            $result = $obUsuario->registroUsuario($_POST);
                
            View::jsonResponse($result);
        }
    
        $validar = false;
        $usuarioAdm = $obUsuario->verificaAdm();
    
        if(count($usuarioAdm)>0){
            $validar = true;
        }
    
        View::renderTemplate('/usuario/usuario.html', ['validar'=>$validar]); 
    }

    public function tabelaUsuario(){
        $obUsuario = new UsuarioDAO();
        $resp = $obUsuario->exibirUsuario();

    //    die(var_dump(['usuarios'=>$resp]));

        View::renderTemplate('/usuario/tabelaUsuario.html', ['usuarios'=>$resp]); 
    }

    public function obterUsuario(){
        $obUsuario = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
            $resp = $obUsuario->obterUsuario($_POST);
                
            View::jsonResponse($resp);
        }
    }

    public function apagarUsuario(){
        $obUsuario = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
            $resp = $obUsuario->deletarUsuario($_POST);
                
            View::jsonResponse($resp);
        }
    }

    public function atualizaUsuario(){
        $obUsuario = new UsuarioDAO();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
            $resp = $obUsuario->atualizarUsuario($_POST);
                
            View::jsonResponse($resp);
        }
    }
    
}