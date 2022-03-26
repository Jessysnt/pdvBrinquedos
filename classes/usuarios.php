<?php 

class Usuario extends Conexao{

	public function registroUsuario($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$data = date('Y-m-d');

		$sql = "INSERT into usuarios (nome, user, email, senha, cargo, dataCaptura) VALUES('$dados[0]', '$dados[1]', '$dados[2]', '$dados[3]', '$dados[4]', '$data')";

		return mysqli_query($conexao, $sql);
	}


	public function login($dados){

		$senha = sha1($dados[1]);

		$select_stmt=$this->conectar()->prepare("SELECT * FROM usuarios WHERE email=:email AND senha=:senha");
		$select_stmt->execute(array(':email'=>$dados[0], ':senha'=>$senha));
		$result=$select_stmt->fetch(PDO::FETCH_ASSOC);

		if($select_stmt->rowCount() > 0){
			$_SESSION['usuario'] = $result;
			return 1;
		}
		else{
			return 0;
		} 
	}

	public function trazerId($dados){

		$senha = sha1($dados[1]);

		$select_stmt=$this->conectar()->prepare("SELECT id FROM usuarios WHERE email=:email AND senha=:senha");
		$select_stmt->execute(array(':email'=>$dados[0], ':senha'=>$senha));
		$result=$select_stmt->fetch(PDO::FETCH_ASSOC);

		return $result[0];
	}


	public function obterUsuario($idusuario){


		$select_stmt=$this->conectar()->prepare("SELECT id, nome, user, email, cargo FROM usuarios WHERE id=:idusuario");
		$select_stmt->execute(array(':idusuario'=>$idusuario));
		$result=$select_stmt->fetch(PDO::FETCH_ASSOC);

		return $result;

	}



	public function atualizarUsuario($dados){

		$update_stmt=$this->conectar()->prepare("UPDATE usuarios SET nome=:nome, user=:user, email=:email, cargo=:cargo WHERE id=:id");
		$update_stmt->execute(array(':id'=>$dados[0],':nome'=>$dados[1], ':user'=>$dados[2], ':email'=>$dados[3], ':cargo'=>$dados[4]));
		$result=$update_stmt->fetch(PDO::FETCH_INTO);
					
		return $result;
	}




	public function deletarUsuario($idusuario){

		$delete_stmt=$this->conectar()->prepare("DELETE FROM usuarios WHERE id=:id");
		$delete_stmt->execute(array(':id'=>$idusuario));
		$result=$delete_stmt->fetch();

		return $result;
	}

}

?>