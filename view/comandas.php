<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>

<title>Comanda de Vendas</title>
<?php require_once "menu.php"; ?>
 
<div class="container">
	<h3>Abrir Comanda</h3>
 
	<div class="row">
		<div class="col-sm-3">
			<div class="form-check form-check-inline ">
			  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="cpf" value="opcao1">
			  <label class="form-check-label" for="inlineRadio1">CPF</label>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-check form-check-inline ">
			  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="numero" value="opcao2">
			  <label class="form-check-label" for="inlineRadio2">Número</label>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-8">
			<div id="comandaCpf"></div>
			<div id="comandaNumero"></div>
		</div>
	</div>
	



</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cpf').click(function(){
			esconderSessaoVenda();
				$('#comandaCpf').load('comandas/formCpf.php');
				$('#comandaCpf').show();
		});
		$('#numero').click(function(){
				esconderSessaoVenda();
				$('#comandaNumero').load('comandas/formNumero.php');
				$('#comandaNumero').show();
			});
		});

		function esconderSessaoVenda(){
			$('#comandaCpf').hide();
			$('#comandaNumero').hide();
		}

</script>

<?php 
}else{
	header("location:../index.php");
}
?>