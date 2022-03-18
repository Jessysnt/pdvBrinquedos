<?php 
session_start();
if(isset($_SESSION['usuario'])){

?>


	<head>
		<title>Brinquedos</title>
		<?php require_once "menu.php"; ?>
		<?php require_once "../classes/conexao.php"; 
		$c= new conectar();
		$conexao=$c->conexao();
		?>

		<style>
		    td {text-align: center;}
		    th {text-align: center;}
		 </style>
	</head>
	<body>

		<div class="container">
			<h1>Preços</h1>
			
			<div class="row">
				<ul class="nav nav-tabs nav-justified">
					<li role="presentation" ><a href="produtos.php">Cadastrar Produtos</a></li>
					<li role="presentation" class="active"><a href="produtov.php">Preço para venda</a></li>
					<li role="presentation"><a href="estoque.php">Estoque</a></li>
				</ul>
			</div>	
			</br>
			<div class="row">
				<div class="col-sm-4">
					<form method="post" id="frmProdutov" enctype="multipart/form-data">
						<div class="form-group">
						    <label for="nome">Brinquedo</label>
						    <select class="form-control input-sm" id="produtoSelect" name="produtoSelect">
						    	<option value="A">Selecionar</option>
								<?php
									$sql="SELECT id_produto, nome
									from produtos";
									$result=mysqli_query($conexao,$sql);

									while ($produto=mysqli_fetch_row($result)):
								?>
									<option value="<?php echo $produto[0] ?>"><?php echo $produto[1] ?></option>
								<?php endwhile; ?>
						    </select>
						</div>
						<div class="form-group">
						    <label for="lote">Lote</label>
						    <input type="text" class="form-control" id="lote" name="lote">
						</div>
						<div class="form-group">
						    <label for="quantidade">Quantidade</label>
						    <input type="text" class="form-control" id="quantidade" name="quantidade">
						</div>
						<div class="form-group">
						    <label for="comp">Preço comprado</label>
						    <!--<input type="text" class="form-control" id="comp" name="comp"> -->
						    <input type="text" class="form-control" id="comp" name="comp" >
						</div>
						<div class="form-group">
						    <label for="ven">Preço vendido</label>
						    <input type="text" class="form-control" id="ven" name="ven">
						</div>
						
						<span type="submit" class="btn btn-primary btn-block" id="btnAddProdutov">Adicionar</span>
						
					</form>

				
				</div>
				<div class="col-sm-8">
					<div id="tabelaProdvLoad"></div>
				</div> 
			</div>
		</div>

		<!-- Button trigger modal -->


		<!-- Modal -->
		<div class="modal fade" id="abremodalUpdateProdutov" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar Produto</h4>
					</div>
					<div class="modal-body">
						<form id="frmProdutovU" enctype="multipart/form-data">
							<input type="text" hidden="" id="idprodvU" name="idprodvU">
							
							<label>Brinquedo</label>
						    <select class="form-control input-sm" id="produtoSelectU" name="produtoSelectU">
						    	<option value="A">Selecionar</option>
								<?php
									$sql="SELECT id_produto, nome
									from produtos";
									$result=mysqli_query($conexao,$sql);

									while ($produto=mysqli_fetch_row($result)):
								?>
									<option value="<?php echo $produto[0] ?>"><?php echo $produto[1] ?></option>
								<?php endwhile; ?>
						    </select>
							<label>Lote</label>
							<input type="text" class="form-control input-sm" id="loteU" name="loteU">
							<label>Quantidade</label>
							<input type="text" class="form-control input-sm" id="quantidadeU" name="quantidadeU">
							<label>Preço comprado</label>
							<input type="text" class="form-control input-sm" id="compU" name="compU">
							<label>Preço vendido</label>
							<input type="text" class="form-control input-sm" id="venU" name="venU">
							
							<input type="text" hidden="" id="idestoqueU" name="idestoqueU">
							<input type="text" hidden="" id="quantotalU" name="quantotalU">

						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAtualizarProdutovU" class="btn btn-primary col-md" data-dismiss="modal">Atualizar</button>

					</div>
				</div>
			</div>
		</div> 

	</body>



	<script type="text/javascript">
		
		function formatarMoeda(ven) {
        var elemento = document.getElementById('ven');
        var valor = elemento.value;

        valor = valor + '';
        valor = parseInt(valor.replace(/[\D]+/g, ''));
        valor = valor + '';
        valor = valor.replace(/([0-9]{2})$/g, ".$1");

        if (valor.length > 6) {
            valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, "$1.$2");
        }

        elemento.value = valor;
        if(valor == 'NaN') elemento.value = '';
    }
	</script>
	

	<script type="text/javascript">
		
		function adicionarProdutov(idprodv){
			//alert(idprodv);
			$.ajax({
				type:"POST",
				data:"idprodv=" + idprodv,
				url:"../procedimentos/produtov/obterProdutov.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					
					$('#idprodvU').val(dado['id_prodv']);
					$('#produtoSelectU').val(dado['id_produto']);
					$('#loteU').val(dado['lote']);
					$('#quantidadeU').val(dado['quantidade']);
					$('#compU').val(dado['preco_comp']);
					$('#venU').val(dado['preco_ven']);
					$('#idestoqueU').val(dado['id_estoque']);
					$('#quantotalU').val(dado['quantotal']);
				}
			});
		}

		function deletarProdutov(idprodv){
			alertify.confirm('Deseja excluir este Brinquedo?', function(){ 
				$.ajax({
					type:"POST",
					data:"idprodv=" + idprodv,
					url:"../procedimentos/produtov/deletarProdutov.php",
					success:function(r){
						//alert(r);
						if(r==1){
							$('#tabelaProdvLoad').load("produtov/tabelaProdv.php");
							alertify.success("Excluido com sucesso!!");
						}else{
							alertify.error("Não foi possível excluir");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado !')
			});
		}
	</script>



	<script type="text/javascript">
		$(document).ready(function(){
			$('#tabelaProdvLoad').load("produtov/tabelaProdv.php");
			$('#btnAddProdutov').click(function(){
				vazios=validarFormVazio('frmProdutov');
				
				if(vazios > 0){
					alertify.alert("Preencha os Campos!!");
					return false;
				}
				
				dados=$('#frmProdutov').serialize();
				//var formData = new FormData(document.getElementById("frmProdutov"));
				//alert(formData);
				$.ajax({
					type: "POST",
					data: dados,
					url:"../procedimentos/produtov/adicionarProdutov.php",
					success:function(r){
						alert(r);
						if(r==1){
							$('#frmProdutov')[0].reset();
							$('#tabelaProdvLoad').load("produtov/tabelaProdv.php");
							alertify.success("Brinquedo Adicionado");
						}else{
							alertify.error("Não foi possível adicionar :(");
						}
					}
				});
			});
		});
	</script>


	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAtualizarProdutovU').click(function(){
				dados=$('#frmProdutovU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/produtov/atualizarProdutov.php",
					success:function(r){
						//alert(r);
						if(r==1){
							//$('#frmProdutovU')[0].reset();
							$('#tabelaProdvLoad').load("produtov/tabelaProdv.php");
							alertify.success("Brinquedo atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar Brinquedo!");
						}
					}
				});
			})
		})
	</script> 

	<script type="text/javascript">
	$(document).ready(function(){
		$('#produtoSelect').select2();
		//$('#produtoSelectU').select2();
	});
</script>
	


<?php 
}else{
	header("location:../index.php");
}
?>