<?php 
session_start();
if(isset($_SESSION['usuario'])){

?>


<!DOCTYPE html>
	<html>
	<head>
		<title>Usuários</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>
		<div class="container">
			<h1>Administrar Usuário</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmRegistro">
						<label>Nome</label>
						<input type="text" class="form-control input-sm" name="nome" id="nome">
						<label>Usuário</label>
						<input type="text" class="form-control input-sm" name="usuario" id="usuario">
						<label>Email</label>
						<input type="text" class="form-control input-sm" name="email" id="email">
						<label>Senha</label>
						<input type="text" class="form-control input-sm" name="senha" id="senha">

						<label>Cargo</label>
						<select class="form-control input-sm" id="cargo" name="cargo">
							<option value="A">Selecionar Categoria</option>
							<option value="Supervisor">Supervisor</option>
							<option value="Vendedor">Vendedor</option>
							<option value="admin">Admin</option>
						</select>

						<p></p>
						<span class="btn btn-primary btn-block" id="registro">Adicionar</span>

					</form>
				</div>
				<div class="col-sm-7">
					<div id="tabelaUsuariosLoad"></div>
				</div>
			</div>
		</div>


		<!-- Button trigger modal -->


		<!-- Modal -->
		<div class="modal fade" id="atualizarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Editar Usuário</h4>
					</div>
					<div class="modal-body">
						<form id="frmRegistroU">
							<input type="text" hidden="" id="idUsuario" name="idUsuario">
							<label>Nome</label>
							<input type="text" class="form-control input-sm" name="nomeU" id="nomeU">
							<label>Usuário</label>
							<input type="text" class="form-control input-sm" name="usuarioU" id="usuarioU">
							<label>Email</label>
							<input type="text" class="form-control input-sm" name="emailU" id="emailU">
							<label>Cargo</label>
							<select class="form-control input-sm" id="cargoU" name="cargoU">
								<option value="A">Selecionar Categoria</option>
								<option value="Supervisor">Supervisor</option>
								<option value="Vendedor">Vendedor</option>
								<option value="admin">Admin</option>
							</select>

						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAtualizaUsuario" type="button" class="btn btn-warning" data-dismiss="modal">Atualizar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>

	<script type="text/javascript">
		function adicionarDados(idusuario){
			//alert(idusuario);
			$.ajax({
				type:"POST",
				data:"idusuario=" + idusuario,
				url:"../procedimentos/usuarios/obterUsuarios.php",
				success:function(r){
					dado=jQuery.parseJSON(r);

					$('#idUsuario').val(dado['id']);
					$('#nomeU').val(dado['nome']);
					$('#usuarioU').val(dado['user']);
					$('#emailU').val(dado['email']);
					$('#cargoU').val(dado['cargo']);
				}
			});
		}

		function deletarUsuario(idusuario){
			alertify.confirm('Deseja excluir este usuario?', function(){ 
				$.ajax({
					type:"POST",
					data:"idusuario=" + idusuario,
					url:"../procedimentos/usuarios/deletarUsuarios.php",
					success:function(r){
						//alert(r);
						if(r==1){
							$('#tabelaUsuariosLoad').load("usuarios/tabelaUsuarios.php");
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
			$('#btnAtualizaUsuario').click(function(){

				dados=$('#frmRegistroU').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/usuarios/atualizarUsuarios.php",
					success:function(r){

						if(r==1){
							$('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');
							alertify.success("Editado com sucesso");
						}else{
							alertify.error("Não foi possível editar");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){

			$('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');

			$('#registro').click(function(){

				vazios=validarFormVazio('frmRegistro');

				if(vazios > 0){
					alertify.alert("Preencha os campos!!");
					return false;
				}

				dados=$('#frmRegistro').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/login/registrarUsuario.php",
					success:function(r){
						//alert(r);

						if(r==1){
							$('#frmRegistro')[0].reset();
							$('#tabelaUsuariosLoad').load('usuarios/tabelaUsuarios.php');
							alertify.success("Adicionado com sucesso");
						}else{
							alertify.error("Falha ao adicionar :(");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#cargo').select2();
		//$('#cargoU').select2(); 

	});
</script>



	<?php 
}else{
	header("location:../index.php");
}
?>