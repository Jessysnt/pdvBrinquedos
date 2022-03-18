<?php 
session_start();
if(isset($_SESSION['usuario'])){

?>


	
		<title>Fornecedores</title>
		<?php require_once "menu.php"; ?>
	
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

		</div>



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


<?php 
}else{
	header("location:../index.php");
}
?>