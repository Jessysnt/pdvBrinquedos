<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/produtov.php";
require_once "../../classes/estoque.php";

$c = new conectar();
$conexao = $c->conexao();

$sql = "SELECT id_prodv, id_produto, quantidade, preco_ven FROM produtov ";
$result=mysqli_query($conexao, $sql);

$obj = new produtov();
$objeto = new estoque();

$dadosP = array(
	$_POST['idprodvU'],
	$_POST['produtoSelectU'],
	$_POST['loteU'],
	$_POST['quantidadeU'],
	$_POST['compU'],
	$_POST['venU'],
	$_POST['idestoqueU']
);
echo $obj->atualizarProdutov($dadosP);

//if($prodv != ){
while ($mostrar=mysqli_fetch_array($result)):
	if ($_POST['idprodvU'] == $mostrar[0]) {
		$res = $_POST['quantidadeU'] - $mostrar[2];
		$dados=array(
			$dados[0]=$_POST['idestoqueU'],
			$dados[1]=$res,
			$dados[2]=$_POST['quantotalU'],
		); 
		echo $objeto->atualizaAEstoque($dados);

		if ($_POST['venU'] > $mostrar[3] ) {
			$dadosV=array(
				$dadosV[0]=$_POST['idestoqueU'],
				$dadosV[1]=$_POST['venU']
			); 
			echo $objeto->novoValor($dadosV);
			break;
		}
	} 

	

	else {
			echo 0;
	}
endwhile;
//}else{
//	echo 0;
//}
	

?>