<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>


<?php require_once "../../classes/conexao.php";
$c= new conectar();
$conexao=$c->conexao(); ?>

</br>

		<form method="post" id="frmComandaNumero">	
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<input readonly="" type="text" class="form-control" id="numeroComanda" name="numeroComanda">
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
						<input type="text" class="form-control input-sm" id="quantV" name="quantV">
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

<?php 
	}else{
		header("location:../index.php");
	}
?>