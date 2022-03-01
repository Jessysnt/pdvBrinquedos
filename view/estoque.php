<?php 
session_start();
if(isset($_SESSION['usuario'])){

?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Estoque</title>
		<?php require_once "menu.php"; ?>
		<?php require_once "../classes/conexao.php"; 
			$c= new conectar();
			$conexao=$c->conexao();
			$sql="SELECT pro.nome, 
					pro.descricao,
					es.quantotal,
					es.preco_ven,
					es.id_estoque
			  from estoque as es 
			  inner join produtos as pro
			  on es.id_produto=pro.id_produto";

			$result=mysqli_query($conexao,$sql);
		?>
	</head>
	<body>
		<div class="container">
			<div id="tabelaClientesLoad">
				<h1>Produtos</h1>
				<div class="row">
					<ul class="nav nav-tabs nav-justified">
						<li role="presentation" ><a href="produtos.php">Cadastrar Produtos</a></li>
						<li role="presentation" ><a href="produtov.php">Preço para venda</a></li>
						<li role="presentation" class="active"><a href="estoque.php">Estoque</a></li>
					</ul>
				</div>	
				</br>
			
				<div class="row">
					<div class="col-sm">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
								<caption><label>Produtos</label></caption>
								<thead>
									<tr>
										<td>Nome</td>
										<td>Descrição</td>
										<td>Quantidade</td>
										<td>Preço Venda</td>

										<!--<td>Editar</td>-->
										
									</tr>
								</thead>
								<tbody>
									<?php while($mostrar=mysqli_fetch_row($result)): ?>
									<tr>
										<td><?php echo $mostrar[0]; ?></td>
										<td><?php echo $mostrar[1]; ?></td>
										<td><?php echo $mostrar[2]; ?></td>
										<td>R$<?php echo $mostrar[3]; ?></td>
									<!--	<td>
											<span  data-toggle="modal" data-target="#abremodal" class="btn btn-warning btn-xs" onclick="adicionar('<?php echo $mostrar[4] ?>')">
												<span class="glyphicon glyphicon-pencil"></span>
											</span>
										</td>
										<td>
											<span class="btn btn-danger btn-xs" onclick="deletar('<?php echo $mostrar[4] ?>')">
												<span class="glyphicon glyphicon-remove"></span>
											</span> 
										</td> -->
										</tr>
									<?php endwhile; ?>
								</tbody>	
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</body>
	</html>

<?php 
}else{
	header("location:../index.php");
}
?>