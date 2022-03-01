<?php

class estoque{

	public function adicionaEstoque($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$quantnova = $dados[2] + $dados[4];

		$sql ="UPDATE estoque SET quantotal = '$quantnova', preco_ven = '$dados[3]' where id_estoque = '$dados[0]' ";

		return mysqli_query($conexao,$sql);
	}

	public function insereEstoque($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		
		$sql="INSERT INTO estoque (id_produto, quantotal, preco_ven) VALUES ('$dados[0]', '$dados[1]', '$dados[2]')";

		return mysqli_query($conexao, $sql);
		
	}

	public function atualizaAEstoque($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$nova = $dados[1] + $dados[2];

		$sql ="UPDATE estoque SET quantotal = '$nova' where id_estoque = '$dados[0]' ";

		return mysqli_query($conexao,$sql);
	}

	public function novoValor($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$sql ="UPDATE estoque SET preco_ven = '$dados[1]' where id_estoque = '$dados[0]' ";

		return mysqli_query($conexao,$sql);
	}

	
}


?>