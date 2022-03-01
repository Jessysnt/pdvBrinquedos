<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/produtov.php";


$obj = new produtov();

echo json_encode($obj->obterProdutov($_POST['idprodv']));

 ?>