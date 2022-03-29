<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/css/bootstrap.css">
	
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
							<img class="imglogo" src="assets/img/logo1.png">
						</p>
						<form id="frmLogin">
							<label>E-mail</label>
							<input type="text" class="form-control input-sm" name="email" id="email">
							<label>Senha</label>
							<input type="password" name="senha" id="senha" class="form-control input-sm">
							<p></p>
							<button type="submit" class="btn btn-primary btn-block" id="entrarSistema">Entrar</button>
							</br>
							<?php if(!$validar):?>
							<a href="registro" class="btn btn-danger btn-sm">Registrar</a>
							<?php endif ?>
													
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
			$('#entrarSistema').click(function(e){

			e.preventDefault();

			vazios=validarFormVazio('frmLogin');

				if(vazios > 0){
					alert("Preencha os campos!!");
					return false;
				}

			dados=$('#frmLogin').serialize();
			$.ajax({
				type:"POST",
				data:dados,
				url:"login",
				success:function(r){
					console.log(r);
					var resp = JSON.parse(r);
					if(resp){
						window.location="painel";
					}else{
						alert(r);
						alertify.error("Acesso Negado!!");
					}
				}
			});
		});
		});
	</script>
</body>
</html>

<!--  -->