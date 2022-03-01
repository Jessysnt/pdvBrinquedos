<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Vendas</title>
	<?php require_once "menu.php"; ?>
</head>
<body>

	<div class="container">
		 <h1>Venda de Produtos</h1>
		 <div class="row">
		 	<div class="col-sm-12">
		 		<span class="btn btn-default" id="vendaProdutosBtn">Vender Produto</span>
		 		<span class="btn btn-default" id="vendasFeitasBtn">Lista de Vendas</span>
		 	</div>
		 </div>
		 <div class="row">
		 	<div class="col-sm-12">
		 		<div id="vendaProdutos"></div>
		 		<div id="vendasFeitas">

		 			
<?php 

	
	//require_once "vendas/vendasRelatorios.php" 

	?>

		 		</div>
		 	</div>
		 </div>
	</div>
</body>
</html>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#vendaProdutosBtn').click(function(){
				esconderSessaoVenda();
				$('#vendaProdutos').load('vendas/vendasDeProdutos.php');
				$('#vendaProdutos').show();
			});
			$('#vendasFeitasBtn').click(function(){
				esconderSessaoVenda();
				$('#vendasFeitas').load('vendas/vendasRelatorios.php');
				$('#vendasFeitas').show();
			});
		});

		function esconderSessaoVenda(){
			$('#vendaProdutos').hide();
			$('#vendasFeitas').hide();
		}

	</script>

<?php 
	}else{
		header("location:../index.php");
	}
 ?>