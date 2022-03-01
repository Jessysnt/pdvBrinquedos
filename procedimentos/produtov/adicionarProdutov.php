<?php 

	session_start();
	require_once "../../classes/conexao.php";
	require_once "../../classes/produtov.php";
	require_once "../../classes/estoque.php";

	$c = new conectar();
	$conexao = $c->conexao();

	$sql="SELECT  id_estoque, id_produto, quantotal, preco_ven FROM estoque";
	$result=mysqli_query($conexao, $sql);

	$idusuario = $_SESSION['iduser'];


	$obj = new produtov();

	$objeto = new estoque();
	

	$dadosP=array(
		$idusuario,
		$_POST['produtoSelect'],
		$_POST['lote'],
		$_POST['quantidade'],
		$_POST['comp'],
		$_POST['ven']
	);
	$idprodv=$obj->adicionarProdutov($dadosP);

	

	if($idprodv > 0){
		
		while ($mostrar=mysqli_fetch_array($result)):
			if($_POST['produtoSelect'] == $mostrar[1]){

				$dados=array(
					$dados[0]=$mostrar[0],
					$dados[1]=$_POST['produtoSelect'],
					$dados[2]=$_POST['quantidade'],
					$dados[3]=$_POST['ven'],
					$dados[4]=$mostrar[2]
				); 
				echo $objeto->adicionaEstoque($dados);
				break;
			} 
		endwhile;
		
		if($mostrar == null){
			$dados=array(
				$dados[0]=$_POST['produtoSelect'],
				$dados[1]=$_POST['quantidade'],
				$dados[2]=$_POST['ven']
			);
			echo $objeto->insereEstoque($dados);
		}		

	}else{
			echo 0;
	}
?>