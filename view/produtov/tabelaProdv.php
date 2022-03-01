	
<?php 
	require_once "../../classes/conexao.php";
	$c= new conectar();
	$conexao=$c->conexao();
	$sql="SELECT pro.nome, 
				pv.lote,
				pv.quantidade,
				pv.preco_comp,
				pv.preco_ven,
				pv.id_prodv
		  from produtov as pv 
		  inner join produtos as pro
		  on pv.id_produto=pro.id_produto";

	$result=mysqli_query($conexao,$sql);


 ?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>Produtos</label></caption>
	<tr>
		<td>Nome</td>
		<td>Lote</td>
		<td>Quantidade</td>
		<td>Preço compra</td>
		<td>Preço VENDA</td>

		<td>Editar</td>
		<td>Excluir</td>
	</tr>

	<?php while($mostrar=mysqli_fetch_row($result)): ?>

	<tr>
		
		<td><?php echo $mostrar[0]; ?></td>
		<td><?php echo $mostrar[1]; ?></td>
		<td><?php echo $mostrar[2]; ?></td>
		<td>R$<?php echo $mostrar[3]; ?></td>		
		<td>R$<?php echo $mostrar[4]; ?></td>		
		
		<td>
			<span  data-toggle="modal" data-target="#abremodalUpdateProdutov" class="btn btn-warning btn-xs" onclick="adicionarProdutov('<?php echo $mostrar[5] ?>')">
				<span class="glyphicon glyphicon-pencil"></span>
			</span>
		</td>
		<td>
			<span class="btn btn-danger btn-xs" onclick="deletarProdutov('<?php echo $mostrar[5] ?>')">
				<span class="glyphicon glyphicon-remove"></span>
			</span>
		</td>
	</tr>
<?php endwhile; ?>
</table>