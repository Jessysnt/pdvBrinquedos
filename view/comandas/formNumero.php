<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>


<?php require_once "../../classes/conexao.php";
$c= new conectar();
$conexao=$c->conexao(); ?>

</br>
<div class="container">
	<section class="direita">
		<form method="post" id="frmComandaNumero">	
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<input readonly="" class="form-control input-sm" id="numComanda" name="numComanda" >
					</div>
					<div class="form-group">
						<label>Produto</label>
						<select class="form-control input-sm" id="produtoVenda" name="produtoVenda">
							<option value="A">Selecionar</option>
							<?php
								$sql="SELECT id_produto, nome from produtos";
								$result=mysqli_query($conexao,$sql);

								while ($produto=mysqli_fetch_row($result)):
							?>
							<option value="<?php echo $produto[0] ?>"><?php echo $produto[1] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group"></div>
					<label>Descrição</label>
							<textarea readonly="" id="descricaoV" name="descricaoV" class="form-control input-sm"></textarea>
					<div class="form-group">
						<label>Quantidade Estoque</label>
						<input readonly="" type="text" class="form-control input-sm" id="quantidadeV" name="quantidadeV">
					</div>
					<div class="form-group">
						<label>Preço</label>
						<input readonly="" type="text" class="form-control input-sm" id="precoV" name="precoV">
					</div>	
					<div class="form-group">
						<label>Quantidade Vendida</label>
						<input type="number" class="form-control input-sm" id="quantV" name="quantV">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<span type="submit" class="btn btn-primary btn-block" id="btAddTemp">Criar</span>
				</div>
				<div class="col-sm-2">
					<span class="btn btn-danger" id="btnLimparComanda">Limpar Comanda</span>
				</div>
			</div>
			
		</form>	
	</section>
		<section class="esquerda">
			<div class="row">
				<div class="col-sm-6">
					<div id="tabComNumTempLoad"></div>
				</div>
			</div>
		</section>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#produtoVenda").select2({
    		minimumInputLength: 3
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabComNumTempLoad').load("comandas/tabComNumTemp.php");

		$('#produtoVenda').change(function(){
			$.ajax({
				type:"POST",
				data:"idproduto=" + $('#produtoVenda').val(),
				url:"../procedimentos/vendas/obterDadosProdutos.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					$('#descricaoV').val(dado['descricao']);
					$('#quantidadeV').val(dado['quantidade']);
					$('#precoV').val(dado['preco']);	
				}
			});
		});

		$('#btAddTemp').click(function(){
			vazios=validarFormVazio('frmComandaNumero');

			var quant = parseInt($('#quantV').val());
			var quantidade = parseInt($('#quantidadeV').val());

			
			if(quant > quantidade){
				alertify.alert("Quantidade inexistente em estoque!!");
				quant = $('#quantV').val("");
				return false;
			}else{
				quantidade = $('#quantidadeV').val();
			}

			if(vazios > 0){
				alertify.alert("Preencha os Campos!!");
				return false;
			}

			dados=$('#frmComandaNumero').serialize();
			$.ajax({
				type:"POST",
				data:dados,
				url:"../procedimentos/comandas/addComandaTemp.php",
				success:function(r){
					//alert(dados);
					//limpar formulário
					//$('#frmVendasProdutos')[0].reset();
					$("#produtoVenda").select2('');
					$('#quantidadeV').val('');
					$('#descricaoV').val('');
					$('#precoV').val('');
					$('#quantV').val('');
					$('#tabComNumTempLoad').load("comandas/tabComNumTemp.php");
				}
			});
		});

		$('#btnLimparComanda').click(function(){
			$.ajax({
				url:"../procedimentos/comandas/limparTemp.php",
				success:function(r){
					$('#tabComNumTempLoad').load("comandas/tabComNumTemp.php");
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