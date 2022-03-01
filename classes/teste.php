<?php 

class teste{
	public function adicionarTeste($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		
		$data=date('Y-m-d');

		$sql = "INSERT into teste ( nome_teste, dataCaptura) VALUES('$dados[0]', '$data')";

		return mysqli_query($conexao, $sql);
	}


	public function obterTeste($idteste){
		$c = new conectar();
		$conexao = $c->conexao();

		$sql = "SELECT nome_teste FROM teste WHERE id_teste='$idteste'";

		$result = mysqli_query($conexao, $sql);
		$mostrar = mysqli_fetch_row($result);

		$dados = array(
			'nome_teste' => $mostrar[0]
		);

		return $dados;
	}	


	/*
	public function atualizarProdutov($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "UPDATE produtov SET id_produto = '$dados[1]', lote = '$dados[2]', quantidade = '$dados[3]', preco_comp = '$dados[4]', preco_ven = '$dados[5]' WHERE id_prodv = '$dados[0]'";

		echo mysqli_query($conexao, $sql);
	}


	public function deletarProdutov($idprodv){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "DELETE FROM produtov WHERE id_prodv = '$idprodv'";

		return mysqli_query($conexao, $sql);
	} */
}

 ?>