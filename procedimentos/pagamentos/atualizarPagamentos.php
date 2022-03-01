<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/pagamentos.php";



$obj = new pagamentos();

$dados = array(
	$_POST['idpagamento'],
	$_POST['pagamentoU']
);

echo $obj->atualizarPagamento($dados);

?>