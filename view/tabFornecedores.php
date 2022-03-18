<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>


		<title>Lista de Fornecedores</title>
		<?php require_once "menu.php" ?>
		<?php require_once "../classes/conexao.php";
			$c = new conectar();
			$conexao = $c->conexao();
			$sql = "SELECT id_fornecedor, nome, fantasia, endereco, email, telefone, cnpj FROM fornecedores";
			$result = mysqli_query($conexao, $sql);
		 ?>

			<div class="container">
					<h1>Fornecedores</h1>

					<div class="row">
						<ul class="nav nav-tabs nav-justified">
							<li role="presentation"><a href="fornecedores.php">Cadastro</a></li>
							<li role="presentation" class="active"><a href="tabFornecedores.php">Listas</a></li>
						</ul>
					</div>
				</br>
				<div class="row">

					<div class="table-responsive">
				
						<table class="table table-hover" >
								
								<thead>
								    <tr>
								      	<th scope="col">Nome</th>
								      	<th scope="col">Nome Fantasia</th>
								      	<th scope="col">Endereço</th>
								      	<th scope="col">E-mail</th>
								      	<th scope="col">Telefone</th>
								      	<th scope="col">CNPJ</th>

								      	<th scope="col">Editar</th>
								      	<th scope="col">Excluir</th>
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
											<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#atualizaFornecedor" onclick="adicionarDados('<?php echo $mostrar[0]; ?>')">
												<span class="glyphicon glyphicon-pencil"></span>
											</span>
										</td>
										<td>
											<span class="btn btn-danger btn-xs" onclick="deletarFornecedor('<?php echo $mostrar[0]; ?>')">
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
			<div class="modal fade" id="atualizaFornecedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
							<button id="btnAdicionarFornecedorU" class="btn btn-primary" data-dismiss="modal">Atualizar</button>

						</div>
					</div>
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
							$('#tabelaFornecedoresLoad').load("tabFornecedores.php");
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
			$('#btnAdicionarFornecedorU').click(function(){
				dados=$('#frmFornecedoresU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/fornecedores/atualizarFornecedores.php",
					success:function(r){

						if(r==1){
							//$('#frmFornecedores')[0].reset();
							$('#tabelaFornecedoresLoad').load("tabFornecedores.php");
							alertify.success("Fornecedor atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar fornecedor");
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