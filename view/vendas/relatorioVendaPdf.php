<?php 
	require_once "../../classes/conexao.php";
	require_once "../../classes/vendas.php";

	$objv= new vendas();


	$c= new conectar();
	$conexao=$c->conexao();
	$idvenda=$_GET['idvenda'];

	 $sql="SELECT ve.id_venda,
			ve.dataCompra,
			ve.id_cliente,
			pro.nome,
			pro.descricao
	        ve.preco
		from vendas  as ve 
		inner join produtos as pro
		on ve.id_produto=pro.id_produto
		and ve.id_venda='$idvenda'";

	$result=mysqli_query($conexao,$sql);

	$ver=mysqli_fetch_row($result);

	$comp=$ver[0];
	$data=$ver[1];
	$idcliente=$ver[2];

 ?>	

 

 	<link rel="stylesheet" type="text/css" href="../../lib/bootstrap/css/bootstrap.css">
 
 		<img src="../../img/logo2.png" width="150" height="100">
 		<br>
 		<table class="table">
 			<tr>
 				<td>Data: 
 				<?php echo date("d/m/Y", strtotime($data)) ?>
 				</td>
 			</tr>
 			<tr>
 				<td>Comprovante: <?php echo $comp ?></td>
 			</tr>
 			<tr>
 				<td>Cliente: <?php echo $objv->nomeCliente($idcliente); ?></td>
 			</tr>
 		</table>


 		<table class="table">
 			<tr>
 				<td>Produto</td>
 				<td>Descricao</td>
 				<td>Preco</td>
 				<td>Quantidade</td>
 			</tr>

 			<?php 
 			$sql="SELECT ve.id_venda,
						ve.dataCompra,
						ve.id_cliente,
						pro.nome,
						pro.descricao,
				        ve.preco,
				        ve.quantidade,
				        ve.total_venda
					from vendas  as ve 
					inner join produtos as pro
					on ve.id_produto=pro.id_produto
					and ve.id_venda='$idvenda'";

			$result=mysqli_query($conexao,$sql);
			$total=0;
			while($mostrar=mysqli_fetch_row($result)):
 			 ?>

 			<tr>
 				<td><?php echo $mostrar[3]; ?></td>
 				<td><?php echo $mostrar[4]; ?></td>
 				<td><?php echo "R$ ".$mostrar[5]; ?></td>
 				<td><?php echo $mostrar[6]; ?></td>
 				
 			</tr>
 			<?php 
 				$total=$total + $mostrar[7];
 			endwhile;
 			 ?>
 			 <tr>
 			 	<td>Total=  <?php echo "R$ ".$total; ?></td>
 			 </tr>
 		</table>
