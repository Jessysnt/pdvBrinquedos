<?php 
	session_start();
	require_once "../../classes/conexao.php";
	$c= new conectar();
	$conexao=$c->conexao();

	
	$idproduto=$_POST['prodVenda'];
	$descricao=$_POST['descricaoV'];
	$quantidade=$_POST['quantidadeV'];
	$quantV=$_POST['quantV'];
	$preco=$_POST['precoV'];

	$min = 1;
    $max = 100;
	$numComanda = rand($min,$max);

	$sql="SELECT nome, descricao 
			from produtos
			where id_produto='$idproduto'";
	$result=mysqli_query($conexao,$sql);

	$nomeproduto=mysqli_fetch_row($result)[0];

	$sql="SELECT preco_ven, quantotal 
			from estoque
			where id_estoque='$idestoque'";
	$result=mysqli_query($conexao,$sql);

	$nestoque=mysqli_fetch_row($result)[0];

	$sql="SELECT nome_pagamento
			from pagamentos
			where id_pagamento= '$idpagamento'";
	$result=mysqli_query($conexao, $sql);

	$npagamento=mysqli_fetch_row($result)[0];

	$produto=$idproduto."||".
				$nomeproduto."||".
				$descricao."||".
				$preco."||".
				$numComanda."||".
				$quantidade."||".
				$quantV."||".
				$quantV * $preco;

	$_SESSION['tabComprasNumTemp'][]=$produto;




	//ATUALIZAÇÃO DO ESTOQUE - FEITO NO FINAL DO CURSO
	$quantNova = $quantotal - $quantV;
	$sqlU = "UPDATE estoque SET quantotal = '$quantNova' where id_estoque = '$idestoque' ";
		mysqli_query($conexao,$sqlU);

 ?>