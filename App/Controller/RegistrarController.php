<?php

namespace App\Controller;

use Core\Controller;
use \App\Repository\UsuarioDAO;
use \Core\View;

class RegistrarController extends Controller
{
    public function primeiroRegistro(){
        $obUsuarioDAO = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obUsuario=array(
                'nome' => $_POST['nome'],
                'sobrenome' => $_POST['sobrenome'],
                'cpf' => $_POST['cpf'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha'],
                'cargo' => $_POST['cargo'],
                'acessos' => implode(', ', $_POST['acessos']) 
            ); 
            $result = $obUsuarioDAO->registroUsuario($obUsuario);
            View::jsonResponse($result);
        }

        $validar = false;
        $usuarioAdm = $obUsuarioDAO->verificaAdm();
        if(count($usuarioAdm)>0){
            $validar = true;
        }

        View::render('registrar.php', ['validar'=>$validar]); 
    }
}
