<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>


<?php require_once "../../classes/conexao.php";
$c= new conectar();
$conexao=$c->conexao(); ?>


</br>

		<form method="post" id="frmComandaCpf">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				    
				      	<label>Selecionar Cliente</label>
						<select class="form-control input-sm" id="clienteCpf" name="clienteCpf">
							<option value="A">Selecionar</option>
							<?php
							$sql="SELECT id_cliente, cpf from clientes";
								$result=mysqli_query($conexao,$sql);
								while ($cliente=mysqli_fetch_row($result)):
							?>
							<option value="<?php echo $cliente[0] ?>"><?php echo $cliente[1] ?></option>
							<?php endwhile; ?>
						</select>
				    </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Nome </label>
						<input readonly="" type="text" class="form-control input-sm" id="nomeClienteComanda" name="nomeClienteComanda">
					</div>
				</div>
			</div>
				
			<div class="row">
				<div class="col-sm-6">
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
				<div class="col-sm-6">
					<span type="submit" class="btn btn-primary btn-block" id="btnCriarComanda">Criar</span>
				</div>
			</div>
			
		</form>	


<script type="text/javascript">
	$(document).ready(function(){
		$("#clienteCpf").select2({
    		minimumInputLength: 3
		});
		$("#produtoVenda").select2({
    		minimumInputLength: 3
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){

		$('#clienteCpf').change(function(){
			$.ajax({
				type:"POST",
				data:"idcliente=" + $('#clienteCpf').val(),
				url:"../procedimentos/comandas/obterDadosC.php",
				success:function(r){
					dado=jQuery.parseJSON(r);
					$('#nomeClienteComanda').val(dado['nome'] + " " + dado['sobrenome']);
				}
			});
		});

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

		$('#btnAddVenda').click(function(){
			vazios=validarFormVazio('frmVendasProdutos');

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

			dados=$('#frmVendasProdutos').serialize();
			$.ajax({
				type:"POST",
				data:dados,
				url:"../procedimentos/vendas/adicionarProdutoTemp.php",
				success:function(r){
					//limpar formulário
					$('#frmVendasProdutos')[0].reset();
					$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
				}
			});
		});

		$('#btnLimparVendas').click(function(){

		$.ajax({
			url:"../procedimentos/vendas/limparTemp.php",
			success:function(r){
				$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
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