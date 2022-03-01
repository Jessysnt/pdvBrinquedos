<?php 
session_start();
if(isset($_SESSION['usuario'])){

?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Clientes</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>

		<div class="container">
			<h1>Clientes</h1>
			
			<div class="row">
				<ul class="nav nav-tabs nav-justified">
					<li role="presentation" class="active"><a href="clientes.php">Cadastro</a></li>
					<li role="presentation"><a href="tabClientes.php">Lista</a></li>
				</ul>
			</div>	
			</br>
			<div class="row">
				<div class="col-sm-6">
					<form method="post" id="frmClientes">
						<div class="form-group">
						    <label for="nome">Nome</label>
						    <input type="text" class="form-control" id="nome" name="nome" placeholder="Primeiro Nome">
						</div>
						<div class="form-group">
						    <label for="sobrenome">Sobrenome</label>
						    <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome">
						</div>
						<div class="form-group">
						    <label for="endereco">Endereço</label>
						    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço completo">
						</div>
						<div class="form-group">
						    <label for="email">Endereço de email</label>
						    <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" onblur="validateEmail(this)">
						</div>
						<div class="form-group">
						    <label for="telefone">Telefone</label>
						    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Só números">
						</div>
						<div class="form-group">
						    <label for="cpf">CPF</label>
						    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Só números" onblur="validarCPF(this)"/>
						</div>
						
							<span type="submit" class="btn btn-primary btn-block" id="btnAdicionarCliente">Adicionar</span>
						
					</form>

				
				</div>
				<!--<div class="col-sm-8">
					<div id="tabelaClientesLoad"></div>
				</div> -->
			</div>
		</div>

		<!-- Button trigger modal -->


		<!-- Modal -->
		<!--<div class="modal fade" id="atualizaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar Cliente</h4>
					</div>
					<div class="modal-body">
						<form id="frmClientesU">
							<input type="text" hidden="" id="idclienteU" name="idclienteU">
							<label>Nome</label>
							<input type="text" class="form-control input-sm" id="nomeU" name="nomeU">
							<label>Sobrenome</label>
							<input type="text" class="form-control input-sm" id="sobrenomeU" name="sobrenomeU">
							<label>Endereço</label>
							<input type="text" class="form-control input-sm" id="enderecoU" name="enderecoU">
							<label>Email</label>
							<input type="text" class="form-control input-sm" id="emailU" name="emailU">
							<label>Telefone</label>
							<input type="text" class="form-control input-sm" id="telefoneU" name="telefoneU">
							<label>CPF</label>
							<input type="text" class="form-control input-sm" id="cpfU" name="cpfU">
							
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAdicionarClienteU" class="btn btn-primary col-md" data-dismiss="modal">Atualizar</button>

					</div>
				</div>
			</div>
		</div> -->

	</body>
	</html>


	<script type="text/javascript">
		$(document).ready(function(){
			$("#cpf").mask("000.000.000-00");
			$("#telefone").mask("(00)00000-0000");
			$("#cpfU").mask("000.000.000-00");
			$("#telefoneU").mask("(00)00000-0000");

		})
		
		function validarCPF(el){
				if( !_cpf(el.value) ){
					alertify.error("CPF inválido!");
					// apaga o valor
					el.value = "";
				}
		}

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
		function adicionarDados(idcliente){

			$.ajax({
				type:"POST",
				data:"idcliente=" + idcliente,
				url:"../procedimentos/clientes/obterClientes.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					$('#idclienteU').val(dado['id_cliente']);
					$('#nomeU').val(dado['nome']);
					$('#sobrenomeU').val(dado['sobrenome']);
					$('#enderecoU').val(dado['endereco']);
					$('#emailU').val(dado['email']);
					$('#telefoneU').val(dado['telefone']);
					$('#cpfU').val(dado['cpf']);
				}
			});
		}

		function deletarCliente(idcliente){
			alertify.confirm('Deseja excluir este cliente?', function(){ 
				$.ajax({
					type:"POST",
					data:"idcliente=" + idcliente,
					url:"../procedimentos/clientes/deletarClientes.php",
					success:function(r){
						//alert(r);
						if(r==1){
							$('#tabelaClientesLoad').load("tabClientes.php");
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

			$('#tabelaClientesLoad').load("tabClientes.php");

			$('#btnAdicionarCliente').click(function(){


				vazios=validarFormVazio('frmClientes');
				
				if(vazios > 0){
					alertify.alert("Preencha os Campos!!");
					return false;
				}
				
				dados=$('#frmClientes').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/clientes/adicionarClientes.php",
					success:function(r){
						//alert(r);
						
						if(r==1){
							$('#frmClientes')[0].reset();
							$('#tabelaClientesLoad').load("tabClientes.php");
							alertify.success("Cliente Adicionado");
						}else{
							alertify.error("Não foi possível adicionar");
						}
					}
				});
			});
		});
	</script>


<!--	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAdicionarClienteU').click(function(){
				dados=$('#frmClientesU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/clientes/atualizarClientes.php",
					success:function(r){

						if(r==1){
							$('#frmClientes')[0].reset();
							$('#tabelaClientesLoad').load("tabClientes.php");
							alertify.success("Cliente atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar cliente");
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