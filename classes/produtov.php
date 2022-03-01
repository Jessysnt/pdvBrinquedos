<?php 

class produtov{
	
	public function adicionarProdutov($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		
		$sql = "INSERT into produtov (id_usuario, id_produto, lote, quantidade, preco_comp, preco_ven) VALUES('$dados[0]', '$dados[1]', '$dados[2]', '$dados[3]', '$dados[4]', '$dados[5]')";

		$result=mysqli_query($conexao, $sql);
		//return mysqli_query($conexao, $sql);

		return mysqli_insert_id($conexao);
	}


	public function obterProdutov($idprodv){
		$c = new conectar();
		$conexao = $c->conexao();

		$sql = "SELECT pro.id_prodv, pro.id_produto, pro.lote, pro.quantidade, pro.preco_comp, pro.preco_ven, es.id_estoque, es.quantotal FROM estoque AS es inner join produtov as pro on es.id_produto=pro.id_produto WHERE id_prodv='$idprodv'";

		//$sql = "SELECT id_prodv, id_produto, lote, quantidade, preco_comp, preco_ven FROM produtov WHERE id_prodv='$idprodv'";

		$result = mysqli_query($conexao, $sql);
		$mostrar = mysqli_fetch_row($result);

		$dados = array(
			'id_prodv' => $mostrar[0],
			'id_produto' => $mostrar[1],
			'lote' => $mostrar[2],
			'quantidade' => $mostrar[3],
			'preco_comp' => $mostrar[4],
			'preco_ven' => $mostrar[5],
			'id_estoque' => $mostrar[6],
			'quantotal' => $mostrar[7]
		);

		return $dados;
	}	



	public function atualizarProdutov($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "UPDATE produtov SET id_produto = '$dados[1]', lote = '$dados[2]', quantidade = '$dados[3]', preco_comp = '$dados[4]', preco_ven = '$dados[5]' WHERE id_prodv = '$dados[0]'";

		//echo mysqli_query($conexao, $sql);
		return mysqli_query($conexao, $sql);
	}


	public function deletarProdutov($idprodv){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "DELETE FROM produtov WHERE id_prodv = '$idprodv'";

		return mysqli_query($conexao, $sql);
	}
}

 ?>