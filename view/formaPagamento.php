<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>




	<title>Venda</title>
	<?php require_once "menu.php"; ?>
	<?php require_once "../classes/conexao.php";
	$c= new conectar();
	$conexao=$c->conexao(); ?>