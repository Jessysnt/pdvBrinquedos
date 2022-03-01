<?php 

session_start();
require_once "../../classes/conexao.php";
require_once "../../classes/teste.php";


$idusuario = $_SESSION['iduser'];


$obj = new teste();

$dados = array(
	$_POST['nome']
);

echo $obj->adicionarTeste($dados);

?>