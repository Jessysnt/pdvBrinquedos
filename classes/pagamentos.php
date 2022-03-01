<?php 

class pagamentos{
	public function adicionarPagamento($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "INSERT into pagamentos (id_usuario, nome_pagamento, dataCaptura) VALUES('$dados[0]', '$dados[1]', '$dados[2]')";

		return mysqli_query($conexao, $sql);
	}


	public function atualizarPagamento($dados){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "UPDATE pagamentos SET nome_pagamento = '$dados[1]' WHERE id_pagamento = '$dados[0]'";

		echo mysqli_query($conexao, $sql);
	}


	public function deletarPagamento($idpagamento){
		$c = new conectar();
		$conexao = $c->conexao();
		

		$sql = "DELETE FROM pagamentos WHERE id_pagamento = '$idpagamento'";

		return mysqli_query($conexao, $sql);
	}
}

 ?>