<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/usuarios.php";


$obj = new usuario();

echo json_encode($obj->obterUsuario($_POST['idusuario']));


 ?>