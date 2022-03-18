<?php 
	
	require_once "../../classes/conexao.php";
	require_once "../../classes/comandas.php";

	$obj= new comandas();

	echo json_encode($obj->obterDadosC($_POST['idcliente']));

 ?>