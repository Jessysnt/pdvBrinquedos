<?php 
session_start();
if(isset($_SESSION['usuario'])){

?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Fornecedores</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>
		<div class="container">
			<h1>Fornecedor</h1>
			<div class="row">
				<ul class="nav nav-tabs nav-justified">
					<li role="presentation" class="active"><a href="fornecedores.php">Cadastro</a></li>
					<li role="presentation"><a href="tabFornecedores.php">Lista</a></li>
				</ul>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<form method="post" id="frmFornecedores">
						<div class="form-group">
						    <label for="nome">Nome</label>
						    <input type="text" class="form-control" id="nome" name="nome" placeholder="Empresa">
						</div>
						<div class="form-group">
						    <label for="fantasia">Nome Fantasia</label>
						    <input type="text" class="form-control" id="fantasia" name="fantasia" placeholder="Nome Fantasia">
						</div>
						<div class="form-group">
						    <label for="endereco">Endereço</label>
						    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço completo">
						</div>
						<div class="form-group">
						    <label for="email">Endereço de e-mail</label>
						    <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" onblur="validateEmail(this)">
						</div>
						<div class="form-group">
						    <label for="telefone">Telefone</label>
						    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Só números">
						</div>
						<div class="form-group">
						    <label for="cnpj">CNPJ</label>
						    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Só números" onblur=""/>
						</div>
						<span type="submit" class="btn btn-primary btn-block" id="btnAdicionarFornecedor">Adicionar</span>
					</form>
					
				</div>
			<!--	<div class="col-sm-8">
					<div id="tabelaFornecedoresLoad"></div>
				</div> -->
			</div>
		</div>

		<!-- Button trigger modal -->


		<!-- Modal -->
		<!-- <div class="modal fade" id="atualizaFornecedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar Fornecedor</h4>
					</div>
					<div class="modal-body">
						<form id="frmFornecedoresU">
							<input type="text" hidden="" id="idfornecedorU" name="idfornecedorU">
							<label>Nome</label>
							<input type="text" class="form-control input-sm" id="nomeU" name="nomeU">
							<label>Nome Fantasia</label>
							<input type="text" class="form-control input-sm" id="fantasiaU" name="fantasiaU">
							<label>Endereço</label>
							<input type="text" class="form-control input-sm" id="enderecoU" name="enderecoU">
							<label>Email</label>
							<input type="text" class="form-control input-sm" id="emailU" name="emailU">
							<label>Telefone</label>
							<input type="text" class="form-control input-sm" id="telefoneU" name="telefoneU">
							<label>CNPJ</label>
							<input type="text" class="form-control input-sm" id="cnpjU" name="cnpjU">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAdicionarFornecedorU" type="button" class="btn btn-primary" data-dismiss="modal">Atualizar</button>

					</div>
				</div>
			</div>
		</div> -->

	</body>
	</html>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#cnpj").mask("00.000.000/0000-00");
			$("#telefone").mask("(00)00000-0000");
			$("#cnpjU").mask("00.000.000/0000-00");
			$("#telefoneU").mask("(00)00000-0000");
		})

		function validateEmail(email) {
		 	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)){
		    	return (true);
		  	}
		    alertify.error("E-mail inválido!");
		    email.value = "";
		    return (false);
		}
	</script>

	<script type="text/javascript">
		function adicionarDados(idfornecedor){

			$.ajax({
				type:"POST",
				data:"idfornecedor=" + idfornecedor,
				url:"../procedimentos/fornecedores/obterFornecedores.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					$('#idfornecedorU').val(dado['id_fornecedor']);
					$('#nomeU').val(dado['nome']);
					$('#fantasiaU').val(dado['fantasia']);
					$('#enderecoU').val(dado['endereco']);
					$('#emailU').val(dado['email']);
					$('#telefoneU').val(dado['telefone']);
					$('#cnpjU').val(dado['cnpj']);

				}
			});
		}

		function deletarFornecedor(idfornecedor){
			alertify.confirm('Deseja excluir este fornecedor?', function(){ 
				$.ajax({
					type:"POST",
					data:"idfornecedor=" + idfornecedor,
					url:"../procedimentos/fornecedores/deletarFornecedores.php",
					success:function(r){
						//alert(r);
						if(r==1){
							$('#tabelaFornecedoresLoad').load("fornecedores/tabFornecedores.php");
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

			$('#tabelaFornecedoresLoad').load("tabFornecedores.php");

			$('#btnAdicionarFornecedor').click(function(){

				vazios=validarFormVazio('frmFornecedores');

				if(vazios > 0){
					alertify.alert("Preencha os Campos!!");
					return false;
				}

				dados=$('#frmFornecedores').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/fornecedores/adicionarFornecedores.php",
					success:function(r){
						//alert(r);
						if(r==1){
							$('#frmFornecedores')[0].reset();
							$('#tabelaFornecedoresLoad').load("tabFornecedores.php");
							alertify.success("Fornecedor Adicionado");
						}else{
							alertify.error("Não foi possível adicionar");
						}
					}
				});
			});
		});
	</script>

<!---	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAdicionarFornecedorU').click(function(){
				dados=$('#frmFornecedoresU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/fornecedores/atualizarFornecedores.php",
					success:function(r){

						if(r==1){
							$('#frmFornecedores')[0].reset();
							$('#tabelaFornecedoresLoad').load("tabFornecedores.php");
							alertify.success("Fornecedor atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar fornecedor");
						}
					}
				});
			})
		})
	</script> -->


	<?php 
}else{
	header("location:../index.php");
}
?>