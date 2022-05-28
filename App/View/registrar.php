<!DOCTYPE html>
<html>
<head>
	<title>Registrar Usuário</title>
	<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/lib/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="assets/lib/alertifyjs/css/themes/default.css">

</head>
<body style="background-color: #818991">
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-danger">
					<div class="panel panel-heading">Administrador</div>
					<div class="panel panel-body">
						<form id="frmRegistro">
							<label>Nome</label>
							<input type="text" class="form-control" name="nome" id="nome">
							<label>Sobrenome</label>
							<input type="text" class="form-control" name="sobrenome" id="sobrenome">
							<label>CPF</label>
							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Só números" onblur="validarCPF(this)">
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" onblur="validateEmail(this)">
							<label>Senha</label>
							<input type="password" class="form-control" name="senha" id="senha">
							<input type="text" class="form-control" name="cargo" id="cargo" value="Administrador">
							<input class="form-control" id="acessos" name="acessos[]" value="1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17">
							<p></p>
							<span class="btn btn-primary" id="registro">Registrar</span>
							<a href="index.php" class="btn btn-default" style="margin-left: 20px;">Voltar Login</a>
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
			$('#cargo').hide();
			$('#acessos').hide();
			$("#cpf").mask("000.000.000-00");

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
						console.log(r);
						var resp = JSON.parse(r);
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
	<script src="assets/lib/jquery.maskMoney.min.js"></script>
    <script src="assets/lib/jquery.mask.js"></script>
	<script src="assets/js/funcoes.js"></script>
    <script src="assets/js/funcaocpf.js"></script>
	<script src="assets/lib/alertifyjs/alertify.js"></script>
    <script src="assets/lib/bootstrap/js/bootstrap.js"></script>
</body>
</html>

