

<?php 
	class produtos{
		public function addImagem($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$sql="INSERT INTO imagens (nome, url) VALUES ('$dados[0]', '$dados[1]')";

		$result=mysqli_query($conexao, $sql);

		return mysqli_insert_id($conexao);
		
		}

		public function inserirProduto($dados){
			$c = new conectar();
			$conexao = $c->conexao();

			$sql="INSERT INTO produtos(id_imagem, id_usuario, nome, descricao) VALUES ('$dados[0]', '$dados[1]', '$dados[2]', '$dados[3]')";

			return mysqli_query($conexao, $sql);

		}


		public function obterProduto($idproduto){
			$c = new conectar();
			$conexao = $c->conexao();

			$sql="SELECT id_produto, nome, descricao  FROM produtos WHERE id_produto='$idproduto'";

			$result=mysqli_query($conexao, $sql);

			$mostrar=mysqli_fetch_row($result);

			$dados=array(
				"id_produto" => $mostrar[0],
				"nome" => $mostrar[1],
				"descricao" => $mostrar[2]
			);

			return $dados;

		}


		public function atualizarProduto($dados){
			$c= new conectar();
			$conexao= $c->conexao();

			$sql="UPDATE produtos set  nome= '$dados[1]', descricao= '$dados[2]' WHERE id_produto='$dados[0]'";

			return mysqli_query($conexao, $sql);

		}


		public function deletarProduto($idproduto){
			$c= new conectar();
			$conexao=$c->conexao();

			$idimagem=self::obterIdImg($idproduto);

			$sql="DELETE from produtos 
					where id_produto='$idproduto'";
			$result=mysqli_query($conexao,$sql);

			if($result){
				$url=self::obterUrlImagem($idimagem);

				$sql="DELETE from imagens 
						where id_imagem='$idimagem'";
				$result=mysqli_query($conexao,$sql);
					if($result){
						if(unlink($url)){
							return 1;
						}
					}
			}
		}


		public function obterIdImg($idProduto){
			$c= new conectar();
			$conexao=$c->conexao();

			$sql="SELECT id_imagem 
					from produtos 
					where id_produto='$idProduto'";
			$result=mysqli_query($conexao,$sql);

			return mysqli_fetch_row($result)[0];
		}

		public function obterUrlImagem($idImg){
			$c= new conectar();
			$conexao=$c->conexao();

			$sql="SELECT url 
					from imagens 
					where id_imagem='$idImg'";

			$result=mysqli_query($conexao,$sql);

			return mysqli_fetch_row($result)[0];
		}

	}
?>