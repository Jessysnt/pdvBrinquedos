
<?php 


require_once "../../classes/conexao.php";
	$c = new conectar();
	$conexao = $c->conexao();

	$sql = "SELECT id_cliente, nome, sobrenome, endereco, email, telefone, cpf FROM clientes";
	$result = mysqli_query($conexao, $sql);

 ?>

<div class="table-responsive">
	
	<table class="table table-hover" style="text-align: center">
		<caption><label>Clientes</label></caption>
			<thead>
			    <tr>
			      	<th scope="col">Nome</th>
			      	<th scope="col">Sobrenome</th>
			      	<th scope="col">Endereço</th>
			      	<th scope="col">E-mail</th>
			      	<th scope="col">Telefone</th>
			      	<th scope="col">CPF</th>

			      	<th scope="col">Editar</th>
			      	<th scope="col">Excluir</th>
			    </tr>
			</thead>
			  	<tbody>
			  		<?php while($mostrar = mysqli_fetch_row($result)): ?>
				    <tr>
				      	<td><?php echo $mostrar[1]; ?></td>
				 		<td><?php echo $mostrar[2]; ?></td>
				 		<td><?php echo $mostrar[3]; ?></td>
				 		<td><?php echo $mostrar[4]; ?></td>
				 		<td><?php echo $mostrar[5]; ?></td>
				 		<td><?php echo $mostrar[6]; ?></td>
				 		<td>
							<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#atualizaCliente" onclick="adicionarDados('<?php echo $mostrar[0]; ?>')">
								<span class="glyphicon glyphicon-pencil"></span>
							</span>
						</td>
						<td>
							<span class="btn btn-danger btn-xs" onclick="deletarCliente('<?php echo $mostrar[0]; ?>')">
								<span class="glyphicon glyphicon-remove"></span>
							</span>
						</td>
				    </tr>
				    <?php  endWhile?>
			  	</tbody>
	</table>

</div>