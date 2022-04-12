<!DOCTYPE html>
<html>
<head>
	<title>Registrar Usuário</title>
	<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/css/bootstrap.css">

</head>
<body style="background-color: #818991">
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-danger">
					<div class="panel panel-heading">Registrar Administrador</div>
					<div class="panel panel-body">
						<form id="frmRegistro">
							<label>Nome</label>
							<input type="text" class="form-control input-sm" name="nome" id="nome">
							<label>Sobrenome</label>
							<input type="text" class="form-control input-sm" name="sobrenome" id="sobrenome">
							<label>Email</label>
							<input type="text" class="form-control input-sm" name="email" id="email">
							<label>Senha</label>
							<input type="password" class="form-control input-sm" name="senha" id="senha">
							<label>Cargo</label>
							<select class="form-control input-sm" name="cargo" id="cargo">
								<option value="" >Selecionar</option>
								<option value="1" >Administrador</option>
								<option value="2" >Gerente</option>
								<option value="3" >Caixa</option>
								<option value="4" >Vendedor</option>
							</select>
							<input type="text" class="form-control input-sm" name="cargo" id="cargo">
							<p></p>
							<span class="btn btn-primary" id="registro">Registrar</span>
							<a href="index.php" class="btn btn-default">Voltar Login</a>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>

	<script src="assets/lib/jquery-3.2.1.min.js"></script>
	<script src="assets/js/funcoes.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#registro').click(function(){

				vazios=validarFormVazio('frmRegistro');

				if(vazios > 0){
					alert("Preencha os Campos!!");
					return false;
				}

				dados=$('#frmRegistro').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"registro",
					success:function(r){
						var resp = JSON.parse(r);
						//console.log(r);
						if(resp){
							//limpar formulário
							$('#frmRegistro')[0].reset();
							$(location).attr('href', 'login');
						}else{
							alert("Erro ao Inserir");
						}
					}
				});
			});
		});
	</script>
</body>
</html>

