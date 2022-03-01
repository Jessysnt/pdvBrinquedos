<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/teste.php";


$obj = new teste();

echo json_encode($obj->obterTeste($_POST['idteste']));


 ?>