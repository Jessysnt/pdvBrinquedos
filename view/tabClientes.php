<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>
	<head>
		<title>Lista de Clientes</title>
		<?php require_once "menu.php" ?>
		<?php require_once "../classes/conexao.php";
			$c= new conectar();
			$conexao=$c->conexao();
			$sql = "SELECT id_cliente, nome, sobrenome, endereco, email, telefone, cpf FROM clientes";
			$result = mysqli_query($conexao, $sql); 
		?>

		<style>
		    td {text-align: center;}
		    th {text-align: center;}
		 </style>
	</head>
		<body>
			<div class="container">
				<div id="tabelaClientesLoad">
					<h1>Clientes</h1>
					
					<div class="row">
						<ul class="nav nav-tabs nav-justified">
							<li role="presentation"><a href="clientes.php">Cadastro</a></li>
							<li role="presentation" class="active"><a href="tabClientes.php">Lista</a></li>
						</ul>
					</div>
					</br>
					
						<div class="table-responsive">
					<div >
						<table class="table table-hover" id="lista">

							<div class="col-8"><input class="col-sm-6" id="filtro-nome" placeholder="Nome"/></div></br>
							</br>
							<thead>			
								<tr>
								  	<th >Nome</th>
								   	<th >Sobrenome</th>
								    <th>Endereço</th>
								    <th>E-mail</th>
								    <th>Telefone</th>
								    <th>CPF</th>

								    <th>Editar</th>
								    <th>Excluir</th>
								</tr>
							</thead>
							<tbody>
							  	<?php while($mostrar = mysqli_fetch_row($result)): ?>
								<tr>
								    <td><?php echo $mostrar[1]; ?></td>
								 	<td><?php echo $mostrar[2]; ?></td>
								 	<td><?php echo $mostrar[3]; ?></td>
								 	<td><?php echo $mostrar[4]; ?></td>
								 	<td><?php echo $mostrar[5]; ?></td>
								 	<td><?php echo $mostrar[6]; ?></td>
								 	<td>
										<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#atualizaCliente" onclick="adicionarDados('<?php echo $mostrar[0]; ?>')">
											<span class="glyphicon glyphicon-pencil"></span>
										</span>
									</td>
									<td>
										<span class="btn btn-danger btn-xs" onclick="deletarCliente('<?php echo $mostrar[0]; ?>')">
											<span class="glyphicon glyphicon-remove"></span>
										</span>
									</td>
								</tr>
								<?php  endWhile?>
							</tbody>
						</table>
					</div>
				</div>
			</div>




			<!-- Modal -->
			<div class="modal fade" id="atualizaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
									<small id="errocpf" class="vermelho"></small>
								</form>
							</div>
							<div class="modal-footer">
								<button id="btnAdicionarClienteU" class="btn btn-primary col-md" data-dismiss="modal">Atualizar</button>

							</div>
						</div>
					</div>
				</div>

		</body>
	</html>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#cpf").mask("000.000.000-00");
			$("#telefone").mask("(00)00000-0000");
			$("#cpfU").mask("000.000.000-00");
			$("#telefoneU").mask("(00)00000-0000");
			$("#btvalidar").mask("000.000.000-00");

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
			//alert(idcliente);
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
		$('#filtro-nome').keyup(function() {
		    var nomeFiltro = $(this).val().toLowerCase();
		    $('table tbody').find('tr').each(function() {
		        var conteudoCelula = $(this).find('td:first').text();
		        var corresponde = conteudoCelula.toLowerCase().indexOf(nomeFiltro) >= 0;
		        $(this).css('display', corresponde ? '' : 'none');
		    });
		});
	</script>




	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAdicionarClienteU').click(function(){
				dados=$('#frmClientesU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/clientes/atualizarClientes.php",
					success:function(r){

						if(r==1){
							//$('#frmClientes')[0].reset();
							$('#tabelaClientesLoad').load("tabClientes.php");
							alertify.success("Cliente atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar cliente");
						}
					}
				});
			})
		})
	</script>


<?php 
	}else{
		header("location:../index.php");
	}
?>