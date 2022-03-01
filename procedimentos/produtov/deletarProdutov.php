<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/produtov.php";

$idprodv = $_POST['idprodv'];

$obj = new produtov();

echo $obj->deletarProdutov($idprodv);

?>
