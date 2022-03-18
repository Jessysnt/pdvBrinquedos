<?php 
session_start();
if(isset($_SESSION['usuario'])){

?>

		<title>Clientes</title>
		<?php require_once "menu.php"; ?>


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
			</div>
		</div>


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




<?php 
}else{
	header("location:../index.php");
}
?>