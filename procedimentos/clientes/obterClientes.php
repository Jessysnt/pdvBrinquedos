<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/clientes.php";


$obj = new clientes();

echo json_encode($obj->obterCliente($_POST['idcliente']));


 ?>