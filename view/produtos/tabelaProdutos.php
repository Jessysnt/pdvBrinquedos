
<?php 
	require_once "../../classes/conexao.php";
	$c= new conectar();
	$conexao=$c->conexao();
	$sql="SELECT pro.nome,
					pro.descricao,
					img.url,
					pro.id_produto
		  from produtos as pro 
		  inner join imagens as img
		  on pro.id_imagem=img.id_imagem";

	$result=mysqli_query($conexao,$sql);


 ?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>Produtos</label></caption>
	<tr>
		<td>Nome</td>
		<td>Descrição</td>
		<td>Imagem</td>

		<td>Editar</td>
		<td>Excluir</td>
	</tr>

	<?php while($mostrar=mysqli_fetch_row($result)): ?>

	<tr>
		<td><?php echo $mostrar[0]; ?></td>
		<td><?php echo $mostrar[1]; ?></td>
		<!--<td><?php //echo $mostrar[2]; ?></td>
		<td>R$ <?php //echo $mostrar[3]; ?></td> -->
		<td>

			<?php 
			$imgVer=explode("/", $mostrar[2]) ; 
			$imgurl=$imgVer[1]."/".$imgVer[2]."/".$imgVer[3];
			?>
			<img width="60" height="60" src="<?php echo $imgurl ?>">
		</td>
		
		<td>
			<span  data-toggle="modal" data-target="#abremodalUpdateProduto" class="btn btn-warning btn-xs" onclick="adicionarProduto('<?php echo $mostrar[3] ?>')">
				<span class="glyphicon glyphicon-pencil"></span>
			</span>
		</td>
		<td>
			<span class="btn btn-danger btn-xs" onclick="deletarProduto('<?php echo $mostrar[3] ?>')">
				<span class="glyphicon glyphicon-remove"></span>
			</span>
		</td>
	</tr>
<?php endwhile; ?>
</table>