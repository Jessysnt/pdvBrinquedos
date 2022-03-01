<?php 

require_once "../../classes/conexao.php";
	$c = new conectar();
	$conexao = $c -> conexao();

	$sql = "SELECT id_categoria, nome_categoria, descricao FROM categorias";
	$result = mysqli_query($conexao, $sql);

 ?>




<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>Classificação: </label></caption>
	<tr>
		<td>Faixa etária</td>
		<td>Descrição</td>
		<td>Editar</td>
		<td>Excluir</td>
	</tr>

	<?php while($mostrar = mysqli_fetch_row($result)):  ?>

	<tr>
		<td><?php echo $mostrar[1]; ?></td>
		<td><?php echo $mostrar[2]; ?></td>
		<td>
			<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#atualizaCategoria" onclick="adicionarDado('<?php echo $mostrar[0]; ?>','<?php echo $mostrar[1]; ?>', '<?php echo $mostrar[2]; ?>')">
				<span class="glyphicon glyphicon-pencil"></span>
			</span>
		</td>
		<td>
			<span class="btn btn-danger btn-xs" onclick="deletarCategoria('<?php echo $mostrar[0]; ?>')">
				<span class="glyphicon glyphicon-remove"></span>
			</span>
		</td>
	</tr>


<?php  endWhile?>
</table>