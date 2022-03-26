<?php  

class Conexao{

	private $servidor = "localhost";
	private $usuario = "root";
	private $senha = "";
	private $bd = "lojab";

	public function conectar(){
		try {
			$conexao = new PDO("mysql:host={$this->servidor};dbname={$this->bd}", $this->usuario, $this->senha);
			$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conexao;

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

