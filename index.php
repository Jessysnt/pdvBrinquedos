<?php
	require_once "classes/conexao.php";
	$obj = new conectar();
	$conexao = $obj->conexao();

	$sql = "SELECT * from usuarios where user='admin'";
	$result = mysqli_query($conexao, $sql);

	$validar = 0;
	if(mysqli_num_rows($result) > 0){
		$validar = 1;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
	<script src="lib/jquery-3.2.1.min.js"></script>
	<script src="js/funcoes.js"></script>
	<style>
		.imglogo{
			display: block;
    		margin-left: auto;
    		margin-right: auto;
			width: 60%;
		}
	</style>
</head>
<body style="background-color: #818991">
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel panel-heading">Reino Mágico</div>
					<div class="panel panel-body">
						<p justify-content= center>
							<img class="imglogo" src="img/logo1.png">
						</p>
						<form id="frmLogin">
							<label>E-mail</label>
							<input type="text" class="form-control input-sm" name="email" id="email">
							<label>Senha</label>
							<input type="password" name="senha" id="senha" class="form-control input-sm">
							<p></p>
							<span class="btn btn-primary btn-block" id="entrarSistema">Entrar</span>
							</br>
							<?php if(!$validar):?>
							<a href="registrar.php" class="btn btn-danger btn-sm">Registrar</a>
							<?php endif ?>
													
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#entrarSistema').click(function(){

		vazios=validarFormVazio('frmLogin');

			if(vazios > 0){
				alert("Preencha os campos!!");
				return false;
			}

		dados=$('#frmLogin').serialize();
		$.ajax({
			type:"POST",
			data:dados,
			url:"procedimentos/login/login.php",
			success:function(r){

				if(r==1){
					window.location="view/inicio.php";
				}else{
					alert("Acesso Negado!!");
				}
			}
		});
	});
	});
</script>