<?php

use \App\Entity\Usuario;

if(isset($_POST['email'], $_POST['senha'])){
    $obj = new Usuario;
    
    $obj->email = $_POST['email'];
    $obj->senha = $_POST['senha'];

    $obj->login();
}

