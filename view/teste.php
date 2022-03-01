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
					<form id="frmTeste">
						<label>Nome</label>
						<input type="text" class="form-control input-sm" name="nome" id="nome">
						<p></p>
						<span class="btn btn-primary" id="btnAdicionarTeste">Adicionar</span>
					</form>
				</div>
				<div class="col-sm-6">
					<div id="tabelaTesteLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->

		<!-- Modal -->
	<!--	<div class="modal fade" id="atualizaCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
		</div> -->

	</body>
	</html>


	

<!--	<script type="text/javascript">
		function adicionarProdutov(dados){

			$.ajax({
				type:"POST",
				data:"idprodv=" + idprodv,
				url:"../procedimentos/produtov/obterProdv.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					$('#idprodvU').val(dado['id_prodv']);
					$('#produtoSelectU').val(dado['produtoSelect']);
					$('#loteU').val(dado['lote']);
					$('#quantidadeU').val(dado['quantidade']);
					$('#compU').val(dado['comp']);
					$('#venU').val(dado['ven']);
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

			
		
	</script> -->



	<script type="text/javascript">
		$(document).ready(function(){

			$('#tabelaTesteLoad').load("teste/tabelaTeste.php");

			$('#btnAdicionarTeste').click(function(){

				vazios=validarFormVazio('frmTeste');
				//alert(vazios);
				if(vazios > 0){
					alertify.alert("Preencha os Campos!!");
					return false;
				}

				dados=$('#frmTeste').serialize();
				alert(dados);
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/teste/adicionarTeste.php",
					success:function(r){
						alert(r);
						if(r==1){
					//limpar formulário
							$('#frmTeste')[0].reset();

							$('#tabelaTesteLoad').load("teste/tabelaTeste.php");
							alertify.success("Classificação adicionada com sucesso!");
						}else{
							alertify.error("Não foi possível adicionar AQUI");
						}
					}
				});
			});
		});
	</script>


<!--	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAddProdutovU').click(function(){
				dados=$('#frmProdutovU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/produtov/atualizaProdutov.php",
					success:function(r){

						if(r==1){
							$('#frmProdutovU')[0].reset();
							//$('#tabelaClientesLoad').load("tabClientes.php");
							alertify.success("Brinquedo atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar Brinquedo");
						}
					}
				});
			})
		})
	</script> 

	<script type="text/javascript">
		$(document).ready(function(){
			$('#produtoSelect').select2();
			$('#produtoSelectU').select2();
		});
	</script> -->
	


<?php 
}else{
	header("location:../index.php");
}
?>