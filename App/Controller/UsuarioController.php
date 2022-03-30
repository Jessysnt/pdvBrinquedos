<?php

namespace App\Controller;

use App\Repository\UsuarioDAO;
use Core\View;

class UsuarioController
{
    public function usuarioForm()
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

    
    
}