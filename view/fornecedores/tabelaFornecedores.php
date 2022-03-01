
<?php 


require_once "../../classes/conexao.php";
	$c = new conectar();
	$conexao = $c->conexao();

	$sql = "SELECT id_fornecedor, nome, fantasia, endereco, email, telefone, cnpj FROM fornecedores";
	$result = mysqli_query($conexao, $sql);

 ?>

<div class="table-responsive">
	 <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	 	<caption><label>Fornecedores</label></caption>
	 	<tr>
	 		<td>Nome</td>
	 		<td>Nome Fantasia</td>
	 		<td>Endereço</td>
	 		<td>Email</td>
	 		<td>Telefone</td>
	 		<td>CNPJ</td>

	 		<td>Editar</td>
	 		<td>Excluir</td>
	 	</tr>
 	
	 	<?php while($mostrar = mysqli_fetch_row($result)): ?>
	 	
	 	<tr>
	 		<td><?php echo $mostrar[1]; ?></td>
	 		<td><?php echo $mostrar[2]; ?></td>
	 		<td><?php echo $mostrar[3]; ?></td>
	 		<td><?php echo $mostrar[4]; ?></td>
	 		<td><?php echo $mostrar[5]; ?></td>
	 		<td><?php echo $mostrar[6]; ?></td>
	 		<td>
				<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#atualizaFornecedor" onclick="adicionarDados('<?php echo $mostrar[0]; ?>')">
					<span class="glyphicon glyphicon-pencil"></span>
				</span>
			</td>
			<td>
				<span class="btn btn-danger btn-xs" onclick="deletarFornecedor('<?php echo $mostrar[0]; ?>')">
					<span class="glyphicon glyphicon-remove"></span>
				</span>
			</td>
	 	</tr>

		<?php  endWhile?>
	 
	</table>
</div>