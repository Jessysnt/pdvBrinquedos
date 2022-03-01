<?php 

	require_once "../../classes/conexao.php";
	require_once "../../classes/produtos.php";

	$obj= new produtos();

	$idproduto=$_POST['idproduto'];

	echo $obj->deletarProduto($idproduto);
	
 ?>