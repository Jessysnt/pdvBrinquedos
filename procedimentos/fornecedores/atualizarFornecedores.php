<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/fornecedores.php";



$obj = new fornecedores();

$dados = array(
	$_POST['idfornecedorU'],
	$_POST['nomeU'],
	$_POST['fantasiaU'],
	$_POST['enderecoU'],
	$_POST['telefoneU'],
	$_POST['emailU'],
	$_POST['cnpjU']
);

echo $obj->atualizarFornecedor($dados);

?>