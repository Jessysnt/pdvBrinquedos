<?php 

class categorias{
	public function adicionarCategoria($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "INSERT into categorias (id_usuario, nome_categoria, descricao, dataCaptura) 
		VALUES('$dados[0]', '$dados[1]', '$dados[2]', '$dados[3]')";

		return mysqli_query($conexao, $sql);
	}


	public function atualizarCategoria($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "UPDATE categorias SET nome_categoria = '$dados[1]', descricao = '$dados[2]' 
		WHERE id_categoria = '$dados[0]'";

		echo mysqli_query($conexao, $sql);
	}


	public function deletarCategoria($idcategoria){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "DELETE FROM categorias WHERE id_categoria = '$idcategoria'";

		return mysqli_query($conexao, $sql);
	}
}

 ?>