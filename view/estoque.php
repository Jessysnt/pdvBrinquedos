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
		<style>
		    td {
		      text-align: center;
		    }
		    th {
		      text-align: center;
		    }
		 </style>
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
							<table class="table table-hover table-bordered" id="lista">
								<caption><label>Produtos</label></caption>
								</br>
								<div class="col-4"><input class="col-sm-4" id="filtro-nome" placeholder="Nome"/></div></br>
								</br>
								<thead>
									<tr>
										<th>Nome</th>
										<th>Descrição</th>
										<th>Quantidade</th>
										<th>Preço Venda</th>

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

	<script type="text/javascript">
		$('#filtro-nome').keyup(function() {
		    var nomeFiltro = $(this).val().toLowerCase();
		    $('table tbody').find('tr').each(function() {
		        var conteudoCelula = $(this).find('td:first').text();
		        var corresponde = conteudoCelula.toLowerCase().indexOf(nomeFiltro) >= 0;
		        $(this).css('display', corresponde ? '' : 'none');
		    });
		});
	</script>

<?php 
}else{
	header("location:../index.php");
}
?>