<?php 

session_start();
require_once "../../classes/conexao.php";
require_once "../../classes/pagamentos.php";

$data = date("Y-m-d");
$idusuario = $_SESSION['iduser'];
$pagamento = $_POST['pagamento'];

$obj = new pagamentos();

$dados = array(
	$idusuario,
	$pagamento,
	$data
);

echo $obj->adicionarPagamento($dados);

?>