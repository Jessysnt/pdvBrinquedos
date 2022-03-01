<?php 

session_start();
require_once "../../classes/conexao.php";
require_once "../../classes/categorias.php";

$data = date("Y-m-d");
$idusuario = $_SESSION['iduser'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];

$obj = new categorias();

$dados = array(
	$idusuario,
	$categoria,
	$descricao,
	$data
);

echo $obj->adicionarCategoria($dados);

?>