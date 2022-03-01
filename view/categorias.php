<?php
session_start();
if(isset($_SESSION['usuario'])){

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Classificação</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>

		<div class="container">
			<h1>Classificação dos Briquedos</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmCategorias">
						<label>Faixa Etária</label>
						<input type="text" class="form-control input-sm" name="categoria" id="categoria">
						<label>Descrição</label>
						<input type="text" class="form-control input-sm" name="descricao" id="descricao">
						<p></p>
						<span class="btn btn-primary" id="btnAdicionarCategoria">Adicionar</span>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tabelaCategoriaLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->

		<!-- Modal -->
		<div class="modal fade" id="atualizaCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar classificação</h4>
					</div>
					<div class="modal-body">
						<form id="frmCategoriaU">
							<input type="text" hidden="" id="idcategoria" name="idcategoria">
							<label>Faixa etária</label>
							<input type="text" id="categoriaU" name="categoriaU" class="form-control input-sm">
							<label>Descrição</label>
							<input type="text" id="descricaoU" name="descricaoU" class="form-control input-sm">
						</form>


					</div>
					<div class="modal-footer">
						<button type="button" id="btnAtualizaCategoria" class="btn btn-warning" data-dismiss="modal">Salvar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>


	<script type="text/javascript">
		$(document).ready(function(){

			$('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");

			$('#btnAdicionarCategoria').click(function(){

				vazios=validarFormVazio('frmCategorias');
				//alert(vazios);
				if(vazios > 0){
					alertify.alert("Preencha os Campos!!");
					return false;
				}

				dados=$('#frmCategorias').serialize();
				//alert(dados);
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/categorias/adicionarCategorias.php",
					success:function(r){
						//alert(r);
						if(r==1){
							//limpar formulário
							$('#frmCategorias')[0].reset();

							$('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");
							alertify.success("Classificação adicionada com sucesso!");
						}else{
							alertify.error("Não foi possível adicionar a classificaçao");
						}
					}
				});
			});
		});
	</script>




<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAtualizaCategoria').click(function(){

				dados=$('#frmCategoriaU').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/categorias/atualizarCategorias.php",
					success:function(r){
						if(r==1){
							$('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");
							alertify.success("Atualizado com Sucesso :)");
						}else{
							alertify.error("Não foi possível atualizar :(");
						}
					}
				});
			});
		});
	</script>



<script type="text/javascript">

		function adicionarDado(idCategoria,categoria,descricao){
			$('#idcategoria').val(idCategoria);
			$('#categoriaU').val(categoria);
			$('#descricaoU').val(descricao);
		}


		function deletarCategoria(idcategoria){
			alertify.confirm('Deseja excluir esta categoria?', function(){
				$.ajax({
					type:"POST",
					data:"idcategoria=" + idcategoria,
					url:"../procedimentos/categorias/deletarCategorias.php",
					success:function(r){
						if(r==1){
							$('#tabelaCategoriaLoad').load("categorias/tabelaCategorias.php");
							alertify.success("Excluido com sucesso!!");
						}else{
							alertify.error("Não se pode eliminar");
						}
					}
				});
			}, function(){
				alertify.error('Cancelado !')
			});
		}

</script>




<?php
}else{
	header("location:../index.php");
 }?>
