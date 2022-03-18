
<?php 


require_once "../../classes/conexao.php";
	$c = new conectar();
	$conexao = $c->conexao();

	$sql = "SELECT id, nome, user, email, cargo FROM usuarios ORDER BY cargo";
	
	$result = mysqli_query($conexao, $sql);

 ?>

 <style>
	td {text-align: center;}
    th {text-align: center;}
</style>

<div class="table-responsive">
</br>
	<caption><label>Usuários</label></caption> 
		</br>

	 <table class="table table-hover table-condensed table-bordered"  id="lista">

	 	<div ><input class="col-sm-6" id="filtro-nome" placeholder="Nome"/></div></br>
	 	</br>

		<thead>	
		 	<tr>
		 		<th>Nome</th>
		 		<th>Usuário</th>
		 		<th>Email</th>
		 		<th>Cargo</th>

		 		<th>Editar</th>
		 		<th>Excluir</th>
		 	</tr>
 		</thead>

 		<tbody>	
		 	<?php while($mostrar = mysqli_fetch_row($result)): ?>
		 	
		 	<tr>
		 		<td><?php echo $mostrar[1]; ?></td>
		 		<td><?php echo $mostrar[2]; ?></td>
		 		<td><?php echo $mostrar[3]; ?></td>
		 		<td><?php echo $mostrar[4] ?></td>
		 		<td>
					<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#atualizarUsuario" onclick="adicionarDados('<?php echo $mostrar[0]; ?>')">
						<span class="glyphicon glyphicon-pencil"></span>
					</span>
				</td>
				<td>
					<span class="btn btn-danger btn-xs" onclick="deletarUsuario('<?php echo $mostrar[0]; ?>')">
						<span class="glyphicon glyphicon-remove"></span>
					</span>
				</td>
		 	</tr>

			<?php  endWhile?>
	 	</tbody>
	</table>
</div>

<script type="text/javascript">
	$('#filtro-nome').keyup(function() {
		var nomeFiltro = $(this).val().toLowerCase();
		$('table tbody').find('tr').each(function() {
		    var conteudoCelula = $(this).find('td:first').text();
		    var corresponde = conteudoCelula.toLowerCase().indexOf(nomeFiltro) >= 0;
		    $(this).css('display', corresponde ? '' : 'none');
		});
	});
</script>


