<?php

class comandas{
	public function obterDadosC($idcliente){
		$c= new conectar();
		$conexao=$c->conexao();

		$sql="SELECT id_cliente, nome, sobrenome from clientes where id_cliente = '$idcliente'"; 
		
		$result=mysqli_query($conexao,$sql);

		$ver=mysqli_fetch_row($result);

		$dados=array(
			'nome' => $ver[1],
			'sobrenome' => $ver[2]
		);		
		return $dados;
	}
}

?>