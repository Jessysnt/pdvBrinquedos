<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/usuarios.php";



$obj = new usuario();

$dados = array(
	$_POST['idUsuario'],
	$_POST['nomeU'],
	$_POST['usuarioU'],
	$_POST['emailU'],
	$_POST['cargoU']
);

echo $obj->atualizarUsuario($dados);

?>