<?php 


	require_once "../../classes/conexao.php";
	$c= new conectar();
	$conexao=$c->conexao();

	$dados=$_POST['dados'];

	$idestoque = $dados[0];
	$quantotal = $dados[3].$dados[4].$dados[5].$dados[6];


	
	$sqlU = "UPDATE estoque SET quantotal = '$quantotal' where id_estoque = '$idestoque' ";
		mysqli_query($conexao,$sqlU);

	


 ?>