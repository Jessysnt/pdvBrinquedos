<?php  

class conectar{

	/*private $pdo;

	public function conexao(){
		try {
		$pdo = new PDO("mysql:dbname=lojab; host=localhost", "root", "");
		} catch (PDOException $e) {
			echo "Erro com banco de dados: ".$e->getMessage();
		}
		
		catch(Exception $e){
			echo "Erro generico: ".$e->getMessage();
		}
	
	}*/
	
	private $servidor = "localhost";
	private $usuario = "root";
	private $senha = "";
	private $bd = "lojab";

	public function conexao(){
		$conexao = mysqli_connect($this->servidor, $this->usuario, $this->senha, $this->bd);

		return $conexao;
	} 
}



?>

