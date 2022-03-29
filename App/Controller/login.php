<?php

use \App\Entity\Usuario;

if(isset($_POST['email'], $_POST['senha'])){
    
    $obj = new Usuario;
    
    $obj->email = $_POST['email'];
    $obj->senha = $_POST['senha'];

    $obj->logar();
}

echo "<pre>"; print_r($_POST); echo"</pre>"; exit;

include __DIR__.'/View/menu.php';