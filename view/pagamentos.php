<?php 
session_start();
if(isset($_SESSION['usuario'])){

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Forma de Pagamento</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>

		<div class="container">
			<h1>Forma de Pagamento</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmPagamentos">
						<label>Cadastro</label>
						<input type="text" class="form-control input-sm" name="pagamento" id="pagamento">
						<p></p>
						<span class="btn btn-primary" id="btnAdicionarPagamento">Adicionar</span>
					</form>
				</div>
				<div class="col-sm-6">
					<div id="tabelaPagamentoLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->

		<!-- Modal -->
		<div class="modal fade" id="atualizaPagamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar</h4>
					</div>
					<div class="modal-body">
						<form id="frmPagamentoU">
							<input type="text" hidden="" id="idpagamento" name="idpagamento">
							<label>Forma de Pagamento</label>
							<input type="text" id="pagamentoU" name="pagamentoU" class="form-control input-sm">
						</form>


					</div>
					<div class="modal-footer">
						<button type="button" id="btnAtualizaPagamento" class="btn btn-warning" data-dismiss="modal">Salvar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#tabelaPagamentoLoad').load("pagamentos/tabelaPagamentos.php");

			$('#btnAdicionarPagamento').click(function(){

				vazios=validarFormVazio('frmPagamentos');
				alert(vazios);
				if(vazios > 0){
					alertify.alert("Preencha os Campos!!");
					return false;
				}

				dados=$('#frmPagamentos').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/pagamentos/adicionarPagamentos.php",
					success:function(r){
						alert(r);
						if(r==1){
					//limpar formulário
					$('#frmPagamentos')[0].reset();

					$('#tabelaPagamentoLoad').load("pagamentos/tabelaPagamentos.php");
					alertify.success("Forma de Pagamento adicionada com sucesso!");
				}else{
					alertify.error("Não foi possível adicionar a forma de pagamento");
				}
			}
		});
			});
		});
	</script>




<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAtualizaPagamento').click(function(){

				dados=$('#frmPagamentoU').serialize();
				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/pagamentos/atualizarPagamentos.php",
					success:function(r){
						if(r==1){
							$('#tabelaPagamentoLoad').load("pagamentos/tabelaPagamentos.php");
							alertify.success("Atualizado com Sucesso :)");
						}else{
							alertify.error("Não foi possível atualizar :(");
						}
					}
				});
			});
		});
	</script>



<script type="text/javascript">
	
		function adicionarDado(idPagamento,pagamento){
			$('#idpagamento').val(idPagamento);
			$('#pagamentoU').val(pagamento);
		}


function deletarPagamento(idpagamento){
			alertify.confirm('Deseja excluir?', function(){ 
				$.ajax({
					type:"POST",
					data:"idpagamento=" + idpagamento,
					url:"../procedimentos/pagamentos/deletarPagamentos.php",
					success:function(r){
						if(r==1){
							$('#tabelaPagamentoLoad').load("pagamentos/tabelaPagamentos.php");
							alertify.success("Excluido com sucesso!!");
						}else{
							alertify.error("Não se pode eliminar");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado !')
			});
		}

</script>




<?php 
}else{
	header("location:../index.php");
 }?>