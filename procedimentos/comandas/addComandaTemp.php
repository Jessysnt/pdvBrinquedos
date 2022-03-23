<?php 
	session_start();
	require_once "../../classes/conexao.php";
	$c= new conectar();
	$conexao=$c->conexao();

	$idcliente=$_POST['clienteCpf'];
	$idproduto=$_POST['produtoVenda'];
	$descricao=$_POST['descricaoV'];
	$quantidade=$_POST['quantidadeV'];
	$quantV=$_POST['quantV'];
	$preco=$_POST['precoV'];

	$sql="SELECT nome, sobrenome 
			from clientes 
			where id_cliente='$idcliente'";
	$result=mysqli_query($conexao,$sql);

	$c=mysqli_fetch_row($result);

	$ncliente=$c[0]." ".$c[1];

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
				$ncliente."||".
				$quantidade."||".
				$quantV."||".
				$quantV * $preco."||".
				$npagamento."||".
				$idcliente;

	$_SESSION['tabComprasTemp'][]=$produto;




	//ATUALIZAÇÃO DO ESTOQUE - FEITO NO FINAL DO CURSO
	$quantNova = $quantotal - $quantV;
	$sqlU = "UPDATE estoque SET quantotal = '$quantNova' where id_estoque = '$idestoque' ";
		mysqli_query($conexao,$sqlU);

 ?>