<?php 

class vendas{
	public function obterDadosProduto($idproduto){
		$c= new conectar();
		$conexao=$c->conexao();

		$sql="SELECT pd.nome,
		pd.descricao,
		es.quantotal,
		img.url,
		es.preco_ven
		from produtos as pd 
		inner join imagens as img
		on pd.id_imagem=img.id_imagem
		inner join estoque as es
		on pd.id_produto=es.id_produto 
		and pd.id_produto='$idproduto'";
		$result=mysqli_query($conexao,$sql);

		$ver=mysqli_fetch_row($result);

		$d=explode('/', $ver[3]);

		$img=$d[1].'/'.$d[2].'/'.$d[3];

		$dados=array(
			'nome' => $ver[0],
			'descricao' => $ver[1],
			'quantidade' => $ver[2],
			'url' => $img,
			'preco' => $ver[4]
		);		
		return $dados;
	}

	public function criarVenda(){
		$c= new conectar();
		$conexao=$c->conexao();

		$data=date('Y-m-d');
		$idvenda=self::criarComprovante();
		$dados=$_SESSION['tabelaComprasTemp'];
		$idusuario=$_SESSION['iduser'];
		$r=0;

		for ($i=0; $i < count($dados) ; $i++) { 
			$d=explode("||", $dados[$i]);

			$sql="INSERT into vendas (id_venda,
										id_cliente,
										id_produto,
										id_usuario,
										preco,
										quantidade,
										total_venda,
										nome_pagamento,
										dataCompra)
							values ('$idvenda',
									'$d[9]',
									'$d[0]',
									'$idusuario',
									'$d[3]',
									'$d[6]',
									'$d[7]',
									'$d[8]',
									'$data')";

			
			$r=$r + $result=mysqli_query($conexao,$sql);



		}

		return $r;
	}

	public function criarComprovante(){
		$c= new conectar();
		$conexao=$c->conexao();

		$sql="SELECT id_venda from vendas group by id_venda desc";

		$resul=mysqli_query($conexao,$sql);
		$id=mysqli_fetch_row($resul)[0];

		if($id=="" or $id==null or $id==0){
			return 1;
		}else{
			return $id + 1;
		}
	}
	public function nomeCliente($idCliente){
		$c= new conectar();
		$conexao=$c->conexao();


		 $sql="SELECT sobrenome,nome 
			from clientes 
			where id_cliente='$idCliente'";
		$result=mysqli_query($conexao,$sql);

		$ver=mysqli_fetch_row($result);

		if($ver == 0){
			return 0;
		}else{
			return $ver[1]." ".$ver[0];
		}

		//return $ver[1]." ".$ver[0];
	}

	public function nomePagamento($idPagamento){
		$c= new conectar();
		$conexao=$c->conexao();


		 $sql="SELECT nome_pagamento 
			from pagamentos 
			where id_pagamento='$idPagamento'";
		$result=mysqli_query($conexao,$sql);

		$ver=mysqli_fetch_row($result);

		return $ver[1];
	}

	public function obterTotal($idvenda){
		$c= new conectar();
		$conexao=$c->conexao();


		$sql="SELECT total_venda 
				from vendas 
				where id_venda='$idvenda'";
		$result=mysqli_query($conexao,$sql);

		$total=0;

		while($ver=mysqli_fetch_row($result)){
			$total=$total + $ver[0];
		}

		return $total;
	}
}

?>