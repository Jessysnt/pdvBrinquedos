<?php  

class Conexao{

	private $servidor = "localhost";
	private $usuario = "root";
	private $senha = "";
	private $bd = "lojab";

	public function conectar(){
		try {
			$pdo = new PDO("mysql:host={$servidor};dbname={$bd}", $usuario, $senha);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//return $pdo;

		} catch (PDOException $e) {
			$e->getMessage();
		}
	
	}
	
	/*private $servidor = "localhost";
	private $usuario = "root";
	private $senha = "";
	private $bd = "lojab";*/

	public function conecte(){
		$conexao = mysqli_connect($this->servidor, $this->usuario, $this->senha, $this->bd);

		return $conexao;
	} 
}



?>

