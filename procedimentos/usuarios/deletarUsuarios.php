<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/usuarios.php";

$obj = new usuario();

echo $obj->deletarUsuario($_POST['idusuario']);

?>
