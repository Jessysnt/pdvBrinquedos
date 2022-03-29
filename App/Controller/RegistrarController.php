<?php

namespace App\Controller;

use Core\Controller;
use \App\Repository\UsuarioDAO;
use \Core\View;

class RegistrarController extends Controller
{
    public function primeiroRegistro(){
        $obUsuario = new UsuarioDAO();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $result = $obUsuario->registroUsuario($_POST);
            
            View::jsonResponse($result);
        }

        $validar = false;
        $usuarioAdm = [];//$obUsuario->verificaAdm();

        if(count($usuarioAdm)>0){
            $validar = true;
        }

        View::render('registrar.php', ['validar'=>$validar]); 
    }
}
