<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/pagamentos.php";

$id = $_POST['idpagamento'];

$obj = new pagamentos();

echo $obj->deletarPagamento($id);

?>
