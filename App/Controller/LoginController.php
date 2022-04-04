<?php

namespace App\Controller;

use \App\Repository\UsuarioDAO;
use Core\Controller;
use \Core\View;

class LoginController extends Controller 
{

    public function logar(){

        $obUsuario = new UsuarioDAO();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $resp = $obUsuario->login($_POST);

            if($resp){
                $_SESSION['usuario'] = $resp;
                View::jsonResponse($resp);
            }else{
                View::jsonResponse(['Usuario nao encontrado']);
            }
            //View::jsonResponse($resp);
        }

        $validar = false;
        $usuarioAdm = $obUsuario->verificaAdm();

        if(count($usuarioAdm)>0){
            $validar = true;
        }

        View::render('login.php', ['validar'=>$validar]);
    }

    public function sair(){
        
        session_destroy();
    
        header('Location: /login');
         exit;
    }
}

// if(isset($_POST['email'], $_POST['senha'])){
    
//     $obj = new Usuario;
    
//     $obj->email = $_POST['email'];
//     $obj->senha = $_POST['senha'];

//     $obj->logar();
// }

// echo "<pre>"; print_r($_POST); echo"</pre>"; exit;

// include __DIR__.'/View/menu.php';